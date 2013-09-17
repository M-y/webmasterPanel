<?php

/**
 * Verilen sitenin google index sayısını döndürür
 */
function googleIndex($site) {
  sleep(rand(1, 10)); // bir miktar beklemezsen google banlıyor
  $html = file_get_contents('http://www.google.com/search?q=site:' . urlencode($site));
  preg_match('#<div id="resultStats">(.*?)</div>#si', $html, $indexSayi);
  if ( isset($indexSayi[1]) ) {
    if ( preg_match('#about#i', $indexSayi[1]) ) /// @todo ingilizceye göre yaptık ama?
      preg_match('#[^ ]* (.*?) [^ ]*#si', $indexSayi[1], $indexSayi);
    else
      preg_match('#(.*?) [^ ]*#si', $indexSayi[1], $indexSayi);
  }
  
  if ( isset($indexSayi[1]) )
    return str_replace(',', '', $indexSayi[1]);
  else
    return 0;
}

/**
 * Alexa rank
 */
function alexaRank($site) {
  $sayfa = file_get_contents( 'http://data.alexa.com/data?cli=10&dat=snbamz&url=' . urlencode($site) );
  preg_match('#\<popularity url\=".*?" TEXT\="([0-9]+)"#si', $sayfa, $rank);
  return ( isset($rank[1]) ) ? $rank[1] : 0;
}

/**
 * Google`da arama yaparak bir sitenin kaçıncı sırada olduğunu döndürür. 
 * @note Sadece ilk 10 sayfaya bakar.
 * 
 * @p kelime: Aranacak kelime
 * @p site: kaçıncı sırada olduğu bulunacak site
 * 
 * @return 
 * Sonuçlarda bulursa kaçıncı sırada bulduğunu döndürür
 * Sonuçlarda yoksa 0
 * Hata durumunda false
 */
function googleSiralama($kelime, $site) {
  sleep(rand(1, 10)); // bir miktar beklemezsen google banlıyor
  $sayfa = file_get_contents('http://www.google.com/search?hl=tr&num=100&q=' . urlencode($kelime) . '&start=0&cr=countrytr&as_qdr=all');
  preg_match_all('#<li.*?class="?g.*?<a.*?href="\/url\?q=(.*?)&amp;sa=U.*?>(.*?)<\/a>.*?<\/div><span.*?>(.*?)<\/span>#si', $sayfa, $sonuclar);
  if ( !isset($sonuclar[1]) )
    return false;
  
  $sira = 1;
  foreach($sonuclar[1] as $sonuc) {
    if ( preg_match('#' . preg_quote($site) . '#i', $sonuc) )
      return $sira;
    $sira++;
  }
  
  return 0;
}
?>