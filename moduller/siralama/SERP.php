<?php
/**
 * 
 * @todo kelime silme işlemi
 */
$webmasterPanel -> jsYukle('jquery-1.10.2.min.js');
$webmasterPanel -> jsYukle('http://www.google.com/jsapi');
$webmasterPanel -> jsYukle('grafik.js');

/// Yeni kelime kaydetme
if ( isset($_POST['islem']) && $_POST['islem'] == 'kelimeEkle' ) {
  $kelimeler = $webmasterPanel -> ayarOku("siralama_SERP_{$_GET['SERP']}");
  $kelimeler[] = array('kelime' => $_POST['kelime']);
  $webmasterPanel -> ayarKaydet("siralama_SERP_{$_GET['SERP']}", $kelimeler);
  $webmasterPanel -> mesaj("<b>{$_POST['kelime']}</b> kelimesi kaydedildi. Bir sonraki cron işleminde istatistik tutulmaya başlanacak.");
}

/// Kelime grafikleri
$kelimeler = $webmasterPanel -> ayarOku("siralama_SERP_{$_GET['SERP']}");
echo "<h2>{$_GET['SERP']} Google Sıralama İstatistikleri</h2>";
if ( !isset($kelimeler[0]['istatistik']) )
  $webmasterPanel -> hataMesaji('Bu site için hiç kayıt yok');
else {
  echo '<table class="grafik" style="width: 100%; height: 500px;">';
  echo '<tr><th>Tarih</th>';
  foreach ( $kelimeler as $kelime )
    echo "<th>{$kelime['kelime']}</th>";
  echo '</tr>';
  foreach ( array_keys($kelimeler[0]['istatistik']) as $tarih ) {
    echo '<tr>';
    echo "<td>{$tarih}</td>";
    foreach ( $kelimeler as $kelime )
      if ( isset($kelime['istatistik'][$tarih]) )
	echo "<td>{$kelime['istatistik'][$tarih]}</td>";
      else
	echo "<td>0</td>";
    echo '</tr>';
  }
  echo '</table>';
}

/// Yeni kelime kaydetme formu
echo '<div class="sutun_100">';
  echo '<h3>Kelime Ekle</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=siralama&SERP=' . $_GET['SERP'] . '">';
    echo '<input type="hidden" name="islem" value="kelimeEkle" />';
    echo '<label for="kelime">Kelime:</label>';
    echo '<input type="text" name="kelime" />';
    echo '<input type="submit" value="Ekle" class="button" />';
  echo '</form>';
echo '</div>';

?>