<?php
/**
 * moduller/ klasöründen istenilen bir modülü yükler
 */
require_once('kutuphane/ayarlar.php');

require(anaKlasor . 'kutuphane/webmasterPanel.php');
$webmasterPanel = new webmasterPanel(); /// @warning bu nesne tanımlanmadan önce echo kesinlikle kullanılmamalı

/// Eğer modül çağrılmışsa bul ve yükle
if ( isset($_GET['modul']) ) {
  if ( file_exists(anaKlasor . 'moduller/' . $_GET['modul'] . '/' . $_GET['modul'] . '.php') ) { // klasör var mı?
    require(anaKlasor . 'moduller/' . $_GET['modul'] . '/' . $_GET['modul'] . '.php');
  }
  else if ( file_exists(anaKlasor . 'moduller/' . $_GET['modul'] . '.php') ) { // .php dosyası var mı?
    require(anaKlasor . 'moduller/' . $_GET['modul'] . '.php');
  }
  else // Böyle bir modül yok
    $modulYok = true;
}
else
  $modulYok = true;

if ( isset($modulYok) )
  define('baslik', 'Modüller');
else
  define('baslik', $modul['baslik']);
  
if ( isset($modulYok) )
  $webmasterPanel -> hataMesaji('Modül bulunamadı');

$webmasterPanel -> htmlCiktisiVer();
?>