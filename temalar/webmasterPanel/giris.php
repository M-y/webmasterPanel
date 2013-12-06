<?php
/// Giriş sayfasında ust ve alt php dosyalarını çağırmaya gerek yok. Tamamen özel bir sayfa da oluşturulabilir.
define('baslik', 'Giriş');
require('ust.php');
?>

<?php
/**
 * @todo Kullanıcıları tutan bir veritabanı tablosu oluşturulacak. (Tablo yapısı ana dizindeki webmasterPanel.sql dosyasında eklenemeli)
 * Bir üye olma sayfası ile bu tabloya kayıt girilecek.
 * Aşağıda bir form oluşturularak kullanıcı girişi sağlanacak.
 * Giriş yaptığınıda kullanıcı adı $_SESSION['kullanici'] değişkenine alınacak.
 */
if ( isset($_POST['giris']) ) {
  $_SESSION['cevrimici'] = true;
  $_SESSION['kullanici'] = 'deneme';
  echo "Giriş yaptınız.";
}
else {
?>
<form action="" method="post">
  <input type="submit" name="giris" value="Giriş" />
</form>
<?php } ?>

<?php require('alt.php'); ?>