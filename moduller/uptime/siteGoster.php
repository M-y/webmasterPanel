<?php
echo "<h1>{$_GET['site']} Uptime Grafiği</h1>";

$istatistikler = $webmasterPanel -> ayarOku("uptime_{$_GET['site']}");
if ( !$istatistikler )
  $webmasterPanel -> hataMesaji('Bu site için hiç kayıt yok');
else {
  echo '<table>';
  echo '<tr><th>Tarih</th><th>Durum</th></tr>';
  foreach ( array_keys($istatistikler) as $kontrolZamani ) {
    echo '<tr>';
    echo '<td>' . $kontrolZamani . '</td>';
    echo '<td>' . (($istatistikler[$kontrolZamani]) ? '1' : '0') . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}
?>