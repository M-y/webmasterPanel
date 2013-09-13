<?php
/**
 * Sitelerin veya sunucuların uptime istatistiklerini tutar
 * 
 * baslik: Uptime
 */

echo '<div class="sutun_50">';
echo '<h2>Uptime Modülü</h2>';
  $webmasterPanel -> mesaj('Bu modül sitelerinizin açık olma durumunu belirli zaman aralıklarında kaydederek grafiksel olarak size sunar. ');
echo '</div>';
echo '<div class="clearfix"></div>';

if ( isset($_GET['site']) )
  require('siteGoster.php');
else
  require('anasayfa.php');

?>