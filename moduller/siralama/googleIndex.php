<?php
/**
 * Google Index istatistiklerini listeleyen sayfa
 */
$webmasterPanel -> jsYukle('jquery-1.10.2.min.js');
$webmasterPanel -> jsYukle('http://www.google.com/jsapi');
$webmasterPanel -> jsYukle('grafik.js');

$indexler = $webmasterPanel -> ayarOku("siralama_googleIndex_{$_GET['googleIndex']}");
echo "<h2>{$_GET['googleIndex']} Google Index İstatistikleri</h2>";
if ( !$indexler )
  $webmasterPanel -> hataMesaji('Bu site için hiç kayıt yok');
else {
  echo '<table class="grafik" style="width: 100%; height: 500px;">';
  echo '<tr><th>Tarih</th><th>Google Index</th></tr>';
  foreach ( array_keys($indexler) as $index ) {
    echo '<tr>';
    echo "<td>{$index}</td>";
    echo "<td>{$indexler[$index]}</td>";
    echo '</tr>';
  }
  echo '</table>';
}
?>