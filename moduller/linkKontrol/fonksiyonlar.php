<?php
/**
 * Karşı sitede link var mı diye kontrol eder.
 * 
 * @p site: Link var mı diye kontrol edilecek site (karşı site)
 * @p bulunacakLink: Var mı diye bakılacak link (sizin siteniz)
 * 
 * @return Linki bulursa true, bulamazsa false
 */
function linkKontrol($site, $bulunacakLink) {
  if ( !preg_match('#^http#i', $site) ) /// @todo pek güzel olmadı
    $site = 'http://' . $site;
  $sayfa = file_get_contents($site);
  preg_match('#<body[^>]*>(.*?)</body>#si', $sayfa, $body);
  $body = $body[1];
  preg_match_all('#<a [^>]*href="(.*?)"[^>]*>#si', $body, $linkler);
  $linkler = $linkler[1];
  foreach ( $linkler as $link )
    if ( preg_match('#' . preg_quote($bulunacakLink) . '#i', $link) )
      return true;
  return false;
}
?>