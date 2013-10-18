<?php
/**
 * Domainin kime ait olduğu hakkında bilgi verir. 
 * 
 * baslik: Domain Whois
 */

require(anaKlasor . '/moduller/whois/fonksiyonlar.php');

echo '<div class="sutun_50">';
echo '<h2>Domain Whois Sorgu Modülü</h2>';
  $webmasterPanel -> mesaj('Bu modül domainin kime ait olduğu hakkında bilgi verir. ');
echo '</div>';
echo '<div class="clearfix"></div>';

/// Yeni link kaydet
if ( isset($_POST['domain']) ) {
	$whois=new Whois;
	echo '<textarea style="
    width: 600px;
    height: 400px;
">'.$whois->domain_whois($_POST['domain'])."</textarea>";
}

/// Form
echo '<div class="sutun_100">';
  echo '<h3>Domain Whois Sorgulama</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=whois">';
    echo '<label for="domain">Domain:</label>';
    echo '<input type="text" name="domain" value="webmasterpanel.net"/>';
    echo '<input type="submit" value="Sorgula" class="button" />';
  echo '</form>';
echo '</div>';
?>