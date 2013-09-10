<?php
/**
 * Sitelerinizin pagerank, alexa, belli kelimelerde google sıralaması gibi bilgileri
 * belirli zaman aralıklarında kaydederek grafiksel olarak size sunar. 
 * 
 * baslik: Site Sıralamaları
 */

echo '<div class="sutun_50">';
echo '<h2>Site Sıralamaları Modülü</h2>';
  $webmasterPanel -> mesaj('Bu modül sitelerinizin pagerank, alexa, belli kelimelerde google sıralaması gibi bilgileri belirli zaman aralıklarında kaydederek grafiksel olarak size sunar. ');
echo '</div>';
echo '<div class="clearfix"></div>';

/// Yeni site ekleme işlemi
if ( isset($_POST['islem']) && $_POST['islem'] == 'siteEkle' ) {
  $kaydedilecek = $webmasterPanel -> ayarOku('siralama_siteler');
  if ( !$kaydedilecek ) // Daha önde hiç site kaydedilmemiş
    $kaydedilecek[] = $_POST['site'];
  else
    $kaydedilecek[] = $_POST['site'];
  $webmasterPanel -> ayarKaydet('siralama_siteler', $kaydedilecek);
}

/// Site silme işlemi
if ( isset($_GET['siteSil']) ) {
  $siteler = $webmasterPanel -> ayarOku('siralama_siteler');
  foreach ( $siteler as $site )
    if ( $site != $_GET['siteSil'] )
      $silindi[] = $site;
  if ( isset($silindi) )
    $webmasterPanel -> ayarKaydet('siralama_siteler', $silindi);
  else
    $webmasterPanel -> ayarSil('siralama_siteler');
}

/// Siteleri listele
$siteler = $webmasterPanel -> ayarOku('siralama_siteler');
if ( $siteler ) {
  echo '<ul id="siteler">';
    foreach ( $siteler as $site ) {
      echo '<li>' . $site . ' <a href="' . siteAdresi . '/modul.php?modul=siralama&siteSil=' . $site . '">X</a></li>';
    }
  echo '</ul>';
}

/// Yeni site kaydetme formu
echo '<div class="sutun_100">';
  echo '<h3>Site Ekle</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=siralama">';
    echo '<input type="hidden" name="islem" value="siteEkle" />';
    echo '<label for="site">Site adresi:</label>';
    echo '<input type="text" name="site" />';
    echo '<input type="submit" value="Ekle" class="button" />';
  echo '</form>';
echo '</div>';

?>