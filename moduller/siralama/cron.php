<?php 
// Dakika cinsinden çalışma sıklığı
$webmasterPanel_cronAralik = 720;
?>
<?php
require(anaKlasor . '/moduller/siralama/GTB_PageRank.php');
require(anaKlasor . '/moduller/siralama/fonksiyonlar.php');

$siteler = $webmasterPanel -> ayarOku('siralama_siteler');
if ( $siteler ) {
  foreach ( $siteler as $site ) {
    /// Page Rank
    $oku = $webmasterPanel -> ayarOku("siralama_PR_{$site}");
    if ( !isset($oku[date('d-m-Y')]) ) {
      $pagerank = new GTB_PageRank($site);
      $oku[date('d-m-Y')] = $pagerank->getPageRank();
      $webmasterPanel -> ayarKaydet("siralama_PR_{$site}", $oku);
    }
    
    /// Google Index
    $oku = $webmasterPanel -> ayarOku("siralama_googleIndex_{$site}");
    if ( !isset($oku[date('d-m-Y')]) ) {
      $oku[date('d-m-Y')] = googleIndex($site);
      $webmasterPanel -> ayarKaydet("siralama_googleIndex_{$site}", $oku);
    }
  }
}
?>