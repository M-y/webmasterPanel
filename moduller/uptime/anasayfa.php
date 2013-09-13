<?php
/// Yeni site ekleme işlemi
if ( isset($_POST['islem']) && $_POST['islem'] == 'siteEkle' ) {
  $kaydedilecek = $webmasterPanel -> ayarOku('uptime_siteler');
  if ( !$kaydedilecek ) // Daha önde hiç site kaydedilmemiş
    $kaydedilecek[] = $_POST['site'];
  else
    $kaydedilecek[] = $_POST['site'];
  $webmasterPanel -> ayarKaydet('uptime_siteler', $kaydedilecek);
}

/// Site silme işlemi
if ( isset($_GET['siteSil']) ) {
  $siteler = $webmasterPanel -> ayarOku('uptime_siteler');
  foreach ( $siteler as $site )
    if ( $site != $_GET['siteSil'] )
      $silindi[] = $site;
  if ( isset($silindi) )
    $webmasterPanel -> ayarKaydet('uptime_siteler', $silindi);
  else
    $webmasterPanel -> ayarSil('uptime_siteler');
}

/// Siteleri listele
require('fonksiyonlar.php');
$siteler = $webmasterPanel -> ayarOku('uptime_siteler');
if ( $siteler ) {
  echo '<table id="siteler">';
  echo '<h3>Siteler</h3>';
  echo '<tr><th>Site</th><th>Durum</th></tr>';
    foreach ( $siteler as $site ) {
      echo '<tr>';
	echo '<td><a href="' . siteAdresi . '/modul.php?modul=uptime&site=' . $site . '">' . $site . '</a></td>';
	echo '<td>' . ((acikMi($site)) ? 'Açık' : 'Kapalı') . '</td>';
	echo '<td><a href="' . siteAdresi . '/modul.php?modul=uptime&siteSil=' . $site . '">Sil</a></td>';
      echo '</tr>';
    }
  echo '</table>';
}

/// Yeni site kaydetme formu
echo '<div class="sutun_100">';
  echo '<h3>Site Ekle</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=uptime">';
    echo '<input type="hidden" name="islem" value="siteEkle" />';
    echo '<label for="site">Site adresi:</label>';
    echo '<input type="text" name="site" />';
    echo '<input type="submit" value="Ekle" class="button" />';
  echo '</form>';
echo '</div>';

/// Kontrol sıklığı ayarı
if ( isset($_POST['siklik']) )
  $webmasterPanel -> ayarKaydet('uptime_siklik', $_POST['siklik']);

echo '<div class="sutun_100">';
  echo '<h3>Kaç dakikada bir kontrol yapılacak?</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=uptime">';
    echo '<label for="siklik">Dakika cinsinden kontrol etme sıklığı: </label>';
    echo '<input type="text" name="siklik" value="' . $webmasterPanel -> ayarOku('uptime_siklik') . '" />';
    echo '<input type="submit" value="Kaydet" class="button" />';
  echo '</form>';
echo '</div>';
?>