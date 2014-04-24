<?php
/**
 * Karşı sitede linkiniz var mı diye kontrol eder. 
 * 
 * baslik: Link Kontrol
 * 
 * @todo link silme
 */

require(anaKlasor . '/moduller/linkKontrol/fonksiyonlar.php');

echo '<div class="sutun_50">';
echo '<h2>Link Kontrol Modülü</h2>';
  $webmasterPanel -> mesaj('Bu modül bir sitede sizin sitenizin linki var mı diye kontrol eder. ');
echo '</div>';
echo '<div class="clearfix"></div>';

/// Yeni link kaydet
if ( isset($_POST['islem']) && $_POST['islem'] == 'linkEkle' ) {
  
  if( !filter_var( $_POST['site'] , FILTER_VALIDATE_URL) OR !filter_var( $_POST['link'], FILTER_VALIDATE_URL )):
    die('Üzgünüz, gerçek bir url girmediniz.');
  endif;
  
  $linkler = $webmasterPanel -> ayarOku('linkKontrol_linkler');
  $linkler[] = array(
    'site' => $_POST['site'], 
    'link' => $_POST['link']
    );
  $webmasterPanel -> ayarKaydet('linkKontrol_linkler', $linkler);
}

/// Linkleri listele
$linkler = $webmasterPanel -> ayarOku('linkKontrol_linkler');
if ( is_array($linkler) ) {
  echo '<table>';
  echo '<tr><th>Sizin siteniz</th><th>Karşı site</th><th>Durum</th></tr>';
  foreach ($linkler as $link) {
    echo '<tr>';
    echo "<td>{$link['link']}</td>";
    echo "<td>{$link['site']}</td>";
    echo '<td>' . ( (linkKontrol($link['site'], $link['link'])) ? 'Link var' : 'Link yok' ) . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}

/// Yeni link kaydetme formu
echo '<div class="sutun_100">';
  echo '<h3>Site Ekle</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=linkKontrol">';
    echo '<input type="hidden" name="islem" value="linkEkle" />';
    echo '<label for="site">Karşı site:</label>';
    echo '<input type="text" name="site" />';
    echo '<label for="link">Sizin siteniz:</label>';
    echo '<input type="text" name="link" />';
    echo '<input type="submit" value="Ekle" class="button" />';
  echo '</form>';
echo '</div>';
?>
