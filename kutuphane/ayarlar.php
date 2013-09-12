<?php
/**
 * Bazı genel sabitler ve değişkenler
 * @warning Lazım olan her dosyanın başında require_once ile çağrılmalı
 */

/// index.php dosyasının bulunduğu ana klasör
/// @note / ile bitme'me'li
/// @todo Bunu otomatik oluşturabiliriz. Elle girilmesi uygun değil
define('anaKlasor', '/home/muhammed/DEPO/Webmaster/Webmaster Panel/www');

/// Site adresi
/// @note http:// ile başlamalı
///	  / ile bitme'me'li
define('siteAdresi', 'http://webmasterpanel');

define('sqlSunucu', 'localhost');
define('sqlDB', 'webmasterPanel');
define('sqlUser', 'webmasterPanel');
define('sqlPass', 'SAJ6ZTycxYBMAA3v');

?>