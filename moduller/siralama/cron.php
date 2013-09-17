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
    
    /// Alexa Rank
    $oku = $webmasterPanel -> ayarOku("siralama_alexaRank_{$site}");
    if ( !isset($oku[date('d-m-Y')]) ) {
      $oku[date('d-m-Y')] = alexaRank($site);
      $webmasterPanel -> ayarKaydet("siralama_alexaRank_{$site}", $oku);
    }
    
    /// SERP
    $kelimeler = $webmasterPanel -> ayarOku("siralama_SERP_{$site}");
    if ( is_array($kelimeler) )
      for ( $kelimeSayac = 0; $kelimeSayac < count($kelimeler); $kelimeSayac++ )
	if ( !isset($kelimeler[$kelimeSayac]['istatistik'][date('d-m-Y')]) ) {
	  $kelimeler[$kelimeSayac]['istatistik'][date('d-m-Y')] = googleSiralama($kelimeler[$kelimeSayac]['kelime'], $site);
	  $webmasterPanel -> ayarKaydet("siralama_SERP_{$site}", $kelimeler);
	}
  }
}
?>