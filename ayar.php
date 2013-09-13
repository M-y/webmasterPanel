<?php
require_once('kutuphane/ayarlar.php');
require_once('kutuphane/veritabani.php');

require(anaKlasor . '/kutuphane/webmasterPanel.php');
$webmasterPanel = new webmasterPanel(); /// @warning bu nesne tanımlanmadan önce echo kesinlikle kullanılmamalı

/// Bu sayfanın başlığı (En basitinden <title></title> için kullanılacak)
define('baslik', 'Ayarlar');

$webmasterPanel -> mesaj('Cron işlemlerinin düzgün çalışabilmesi için aşağıdaki kodu linux sisteminizin crontab dosyasına ekleyin. <textarea style="width: 700px;display:block">* * * * * php -f "' . anaKlasor . '/cron.php"</textarea>');

echo '<h3>Tema Seçimi</h3>';

if ( isset($_POST['tema']) )
  $webmasterPanel -> ayarKaydet('webmasterPanel_tema', $_POST['tema']);

echo '<form action="ayar.php" method="post">';
  echo '<select name="tema">';
    foreach ( scandir(anaKlasor . '/temalar') as $tema ) {
      if ( $tema != '.' && $tema != '..' && is_dir(anaKlasor . '/temalar/' . $tema) )
      echo '<option' . ( ($webmasterPanel -> ayarOku('webmasterPanel_tema') == $tema) ? ' selected="1"' : '' ) . ' value="' . $tema . '">' . $tema . '</option>';
    }
  echo '</select>';
  echo '<input type="submit" value="Seç" class="button" />';
echo '</form>';

$webmasterPanel -> htmlCiktisiVer();
?>