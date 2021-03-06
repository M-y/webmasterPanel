<?php
/**
 * Sitelerinizin pagerank, alexa, belli kelimelerde google sıralaması gibi bilgileri
 * belirli zaman aralıklarında kaydederek grafiksel olarak size sunar. 
 * 
 * baslik: Site Sıralamaları
 */

require(anaKlasor . '/moduller/siralama/GTB_PageRank.php');
require(anaKlasor . '/moduller/siralama/fonksiyonlar.php');

echo '<div class="sutun_50">';
echo '<h2>Site Sıralamaları Modülü</h2>';
  $webmasterPanel -> mesaj('Bu modül sitelerinizin pagerank, alexa, belli kelimelerde google sıralaması gibi bilgileri günlük olarak kaydederek grafiksel olarak size sunar. ');
echo '</div>';
echo '<div class="clearfix"></div>';

if ( isset($_GET['PR']) )
  require('pr.php');
else
if ( isset($_GET['googleIndex']) )
  require('googleIndex.php');
else
if ( isset($_GET['alexaRank']) )
  require('alexaRank.php');
else
if ( isset($_GET['SERP']) )
  require('SERP.php');
else
  require('anasayfa.php');



?>