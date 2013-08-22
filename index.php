<?php
require_once('kutuphane/ayarlar.php');
require_once('kutuphane/veritabani.php');

require(anaKlasor . '/kutuphane/webmasterPanel.php');
$webmasterPanel = new webmasterPanel(); /// @warning bu nesne tanımlanmadan önce echo kesinlikle kullanılmamalı

/// Bu sayfanın başlığı (En basitinden <title></title> için kullanılacak)
define('baslik', 'Webmaster Panel');

/// Modülleri listele
$moduller = $webmasterPanel -> moduller();
echo '<ul>';
foreach ( $moduller as $modul ) {
  echo '<li>';
  echo '<a href="' . siteAdresi . '/modul.php?modul=' . $modul['kisaAd'] . '">' . $modul['ad'] . '</a>';
  echo '</li>';
}
echo '</ul>';

$veritabani = new veritabani();

$donen = $veritabani -> kayitOku("SELECT * FROM tablo WHERE test='deneme' or no = 1");
var_dump($donen);

$webmasterPanel -> htmlCiktisiVer();
?>