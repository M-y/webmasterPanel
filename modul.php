<?php
/**
 * moduller/ klasöründen istenilen bir modülü yükler
 */
require_once('kutuphane/ayarlar.php');

require(anaKlasor . '/kutuphane/webmasterPanel.php');
$webmasterPanel = new webmasterPanel(); /// @warning bu nesne tanımlanmadan önce echo kesinlikle kullanılmamalı

echo '<h1><a href="' . siteAdresi . '">Anasayfa</a></h1>';

/// Eğer modül çağrılmışsa dosyasını bul
if ( isset($_GET['modul']) ) {
  if ( file_exists(anaKlasor . '/moduller/' . $_GET['modul'] . '/' . $_GET['modul'] . '.php') ) { // klasör var mı?
    $modulDosyasi = anaKlasor . '/moduller/' . $_GET['modul'] . '/' . $_GET['modul'] . '.php';
  }
  else if ( file_exists(anaKlasor . 'moduller/' . $_GET['modul'] . '.php') ) { // .php dosyası var mı?
    $modulDosyasi = anaKlasor . '/moduller/' . $_GET['modul'] . '.php';
  }
  else // Böyle bir modül yok
    $modulYok = true;
}
else
  $modulYok = true;

/// Modülü yükle
if ( isset($modulYok) ) {
  define('baslik', 'Modüller');
  $webmasterPanel -> hataMesaji('Modül bulunamadı');
}
else {
  define('baslik', $webmasterPanel -> modulAdi($modulDosyasi));
  require($modulDosyasi);
}

$webmasterPanel -> htmlCiktisiVer();
?>