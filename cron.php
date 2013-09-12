<?php
header("Content-Length: 0");
header("Connection: close");
while ( @ob_end_flush() );
flush();

require_once('kutuphane/ayarlar.php');
require(anaKlasor . '/kutuphane/webmasterPanel.php');

$webmasterPanel = new webmasterPanel();
$moduller = $webmasterPanel -> moduller();
foreach ( $moduller as $modul ) {
  $dosya = anaKlasor . '/moduller/' . $modul['kisaAd'] . '/cron.php';
  if ( file_exists($dosya) ) {
    preg_match('#<\?php(.*?)\?>#si', file_get_contents($dosya), $cronSiklik);
    eval($cronSiklik[1]);
    $cronAra = $webmasterPanel -> kayitOku("SELECT sonCalisma FROM cron WHERE modul = '{$modul['kisaAd']}'");
    if ( !$cronAra ) { // Daha önce hiç çalışmamışsa
      $webmasterPanel -> kayitEkle("INSERT INTO cron (modul, sonCalisma) VALUES ('{$modul['kisaAd']}', " . time() . ")");
      include($dosya);
    }
    else
      if ( time() >= $cronAra['sonCalisma'] + $webmasterPanel_cronAralik * 60 ) {
	$webmasterPanel -> kayitGuncelle('UPDATE cron SET sonCalisma = ' . time() . " WHERE modul = '{$modul['kisaAd']}'");
	include($dosya);
      }
  }
}
?>