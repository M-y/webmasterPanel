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
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $adres);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  $dondur = curl_exec($ch);
  curl_close($ch);
  /// @todo gelen header kontrol edilerek açık mı ona göre karar verilmesi lazım
  if ( strlen($dondur) > 0 )
    return true;
  else
    return false;
}
?>