<?php
/**
 * Uptime modülü fonksiyonları
 */

/**
 * Verilen adrese bir sorgu göndererek açık mı diye bakar.
 * 
 * @p adres: Bir domain veya ip
 * 
 * @return Açıksa true
 * 	   Kapalıysa false döndürür. 
 */
function acikMi($adres) {
  if ( !preg_match('#^http#i', $adres) ) /// @todo pek güzel olmadı
    $adres = 'http://' . $adres;
  
  $headers = get_headers($adres); /// @todo bazı sunucular 403 verebiliyor.
  if ( $headers === false )
    return false;
  $durum = substr($headers[0], 9, 1); 
  
  if ( $durum > 3 ) // status code 3 den büyükse sorun vardır
    return false;
  else
    return true;
}
?>