<?php
/**
 * Alexa rank istatistiklerini listeleyen sayfa
 */
$webmasterPanel -> jsYukle('jquery-1.10.2.min.js');
$webmasterPanel -> jsYukle('http://www.google.com/jsapi');
$webmasterPanel -> jsYukle('grafik.js');

$indexler = $webmasterPanel -> ayarOku("siralama_alexaRank_{$_GET['alexaRank']}");
echo "<h2>{$_GET['alexaRank']} Alexa Rank İstatistikleri</h2>";
if ( !$indexler )
  $webmasterPanel -> hataMesaji('Bu site için hiç kayıt yok');
else {
  echo '<table class="grafik" style="width: 100%; height: 500px;">';
  echo '<tr><th>Tarih</th><th>Alexa Rank</th></tr>';
  foreach ( array_keys($indexler) as $index ) {
    echo '<tr>';
    echo "<td>{$index}</td>";
    echo "<td>{$indexler[$index]}</td>";
    echo '</tr>';
  }
  echo '</table>';
}
?>