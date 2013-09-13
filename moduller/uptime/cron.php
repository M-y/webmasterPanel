<?php 
// Dakika cinsinden çalışma sıklığı
$webmasterPanel_cronAralik = $webmasterPanel -> ayarOku('uptime_siklik');
?>
<?php
require('fonksiyonlar.php');

$siteler = $webmasterPanel -> ayarOku('uptime_siteler');
if ( $siteler ) {
  foreach ( $siteler as $site ) {
    $oku = $webmasterPanel -> ayarOku("uptime_{$site}");
    $oku[time()] = acikMi($site);
    $webmasterPanel -> ayarKaydet("uptime_{$site}", $oku);
  }
}
?>