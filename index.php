<?php
require_once('kutuphane/ayarlar.php');
require_once('kutuphane/veritabani.php');

require(anaKlasor . '/kutuphane/webmasterPanel.php');
$webmasterPanel = new webmasterPanel(); /// @warning bu nesne tanımlanmadan önce echo kesinlikle kullanılmamalı

/// Bu sayfanın başlığı (En basitinden <title></title> için kullanılacak)
define('baslik', 'Webmaster Panel');

require(anaKlasor . '/temalar/' . $webmasterPanel -> seciliTema . '/anasayfa.php');

$webmasterPanel -> htmlCiktisiVer();
?>