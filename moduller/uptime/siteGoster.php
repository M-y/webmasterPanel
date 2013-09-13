<?php
$webmasterPanel -> jsYukle('jquery-1.10.2.min.js');
$webmasterPanel -> jsYukle('http://www.google.com/jsapi');
$webmasterPanel -> jsYukle('grafik.js');

echo "<h1>{$_GET['site']} Uptime Grafiği</h1>";

$istatistikler = $webmasterPanel -> ayarOku("uptime_{$_GET['site']}");
if ( !$istatistikler )
  $webmasterPanel -> hataMesaji('Bu site için hiç kayıt yok');
else {
  echo '<table class="grafik" style="width: 100%; height: 500px;">';
  echo '<tr><th>Tarih</th><th>Durum</th></tr>';
  foreach ( array_keys($istatistikler) as $kontrolZamani ) {
    echo '<tr>';
    echo '<td>' . date('c', $kontrolZamani) . '</td>';
    echo '<td>' . (($istatistikler[$kontrolZamani]) ? '1' : '0') . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}

$webmasterPanel -> mesaj('1 açık, 0 kapalı anlamına gelir. ');
?>