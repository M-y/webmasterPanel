<?php
/**
 * Google Page Rank istatistiklerini listeleyen sayfa
 */
$webmasterPanel -> jsYukle('jquery-1.10.2.min.js');
$webmasterPanel -> jsYukle('http://www.google.com/jsapi');
$webmasterPanel -> jsYukle('grafik.js');

$prler = $webmasterPanel -> ayarOku("siralama_PR_{$_GET['PR']}");
echo "<h2>{$_GET['PR']} Google Page Rank İstatistikleri</h2>";
if ( !$prler )
  $webmasterPanel -> hataMesaji('Bu site için hiç kayıt yok');
else {
  echo '<table class="grafik" style="width: 100%; height: 500px;">';
  echo '<tr><th>Tarih</th><th>Page Rank</th></tr>';
  foreach ( array_keys($prler) as $pr ) {
    echo '<tr>';
    echo "<td>{$pr}</td>";
    echo "<td>{$prler[$pr]}</td>";
    echo '</tr>';
  }
  echo '</table>';
}
?>