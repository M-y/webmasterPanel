<?php 
// Dakika cinsinden çalışma sıklığı
$webmasterPanel_cronAralik = 720;
?>
<?php
require('GTB_PageRank.php');
$siteler = $webmasterPanel -> ayarOku('siralama_siteler');
if ( $siteler ) {
  foreach ( $siteler as $site ) {
    $oku = $webmasterPanel -> ayarOku("siralama_PR_{$site}");
    if ( !isset($oku[date('d-m-Y')]) ) {
      $pagerank = new GTB_PageRank($site);
      $oku[date('d-m-Y')] = $pagerank->getPageRank();
      $webmasterPanel -> ayarKaydet("siralama_PR_{$site}", $oku);
    }
  }
}
?>