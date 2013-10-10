<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);
include('functions.php');

?>
<script type="text/javascript">
	$(":submit").attr("disabled", false);
	$("#submit").val("SORGULA");		 
</script>
<?php
if ( isset($_POST['siteler']) ) { $siteler = $_POST['siteler']; } 
if ( isset($_POST['user_city']) AND !empty($_POST['user_city']) ) { $user_city = $_POST['user_city']; } 
else {die('Hata! Site adresi yazılmadı');} // site adı belirtilmemişse script çalışmayı durdursun

/* 
Bazı resimler hemen her temada olabiliyor. 
Bu resimleri filtrelemek gerekiyor. 
Filtrelenmesi gereken resimleri arrayla belirtiyoruz.
*/
$filtre = array(
"/logo.png/",
"/facebook.png/",
"/digg.png/",
"/youtube.png/",
"/stumble.png/",
"/twitter.png/",
"/wp-content\/uploads/",
);

// demo sitesine bağlan
$body = curl($user_city);

// demodaki resimlerin urlsini alalım
preg_match_all("/wp-content\/themes\/(.*?)\/(.*?jpg|.*?jpeg|.*?gif|.*?png)/",$body,$imgs);

// filtre fonksiyonundan geçirelim
$imgs = array_unique($imgs[2]);
$imgs = filtrele($imgs);
$imgs = array_unique($imgs);

// sıralayalım, bu gerekli değil aslında ama :D
sort($imgs);

// her bir resmi googlede arayıp temamızdaki resimleri kullanan siteleri bulalım. Asıl arama kısmı burası
foreach ( $imgs as $a ) {

	for ( $i=1; $i<6; $i++ ) {
		
		gsearch($a,$i);
		
	}
	
}

// Eğer kullanıcı siteler kutucuğunu boş bırakmadıysa, bu siteleri arama sonuçlarında göstermemek için çıkaralım.
if ( !empty($siteler) ) { $urlarray = site_cikart($urlarray,$siteler); }
$urlarray = array_unique($urlarray);

?><?php /* Çıktı */

echo '<div>Şu resimlere göre arama yapıldı</div><div><ul>';

foreach ( $imgs as $img ) {

	echo '<li>'.$img.'</li>';

}

echo '</li></div>';

echo '<div>Bulunan Siteler</div><div><ul>';

foreach ( $urlarray as $url ) {

	echo '<li>'.$url.'</li>';

}

echo '</li></div>';
?>