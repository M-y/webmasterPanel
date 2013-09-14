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
?>