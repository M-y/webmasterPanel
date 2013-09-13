<?php
require_once('ayarlar.php');
require_once('veritabani.php');
ob_start();

/**
 * Webmaster Panel Sınıfı
 */
class webmasterPanel extends veritabani {
  
  /**
   * Özellik tanımlamaları
   */
  
  /// temalar klasöründeki tema klasorünün ismi
  public $seciliTema = 'webmasterPanel';
  
  /// html çıktısında head içine bu değişken yazılır. 
  private $html_head = '';
  
  function __construct() {
    parent::__construct();
    if ( $tema = $this -> ayarOku('webmasterPanel_tema') )
      $this -> seciliTema = $tema;
  }
  
  /**
   * Temayı yükleyip html çıktısını verir. 
   */
  function htmlCiktisiVer() {
    $this -> jsYukle(siteAdresi . '/cron.php'); /// Cronu her sayfada çağır @todo cron`un ajax ile çağrılması lazım
    
    $orta = ob_get_contents();
    ob_end_clean();
    
    require(anaKlasor . '/temalar/' . $this -> seciliTema . '/ust.php');
    
    echo $orta;
    
    require(anaKlasor . '/temalar/' . $this -> seciliTema . '/alt.php');
  }
  
  /**
   * <head></head> arasına bişey eklemek için kullanılır.
   * @warning htmlCiktisiVer fonksiyonu çalışmadan önce çağrılması gerekir
   */
  function headEkle($eklenecek) {
    $this -> html_head .= $eklenecek;
  }
  
  /**
   * head bölümünde css çağırır.
   * @p $css: http:// ile başlamazsa css/ dizininden çağırır
   * @warning htmlCiktisiVer fonksiyonu çalışmadan önce çağrılması gerekir
   */
  function cssYukle($css) {
    $this -> headEkle('<link type="text/css" href="' . ( (preg_match('#^http://*#i', $css)) ? $css : siteAdresi . '/css/' . $css ) . '" rel="styleSheet" />');
  }
  
  /**
   * head bölümünde javascript çağırır.
   * @p $js: http:// ile başlamazsa js/ dizininden çağırır
   * @warning htmlCiktisiVer fonksiyonu çalışmadan önce çağrılması gerekir
   */
  function jsYukle($js) {
    $this -> headEkle('<script src="' . ( (preg_match('#^http://*#i', $js)) ? $js : siteAdresi . '/js/' . $js ) . '" type="text/javascript"></script>');
  }
  
  /**
   * Afilli bir mesaj
   */
  function mesaj($mesaj) {
    require(anaKlasor . '/temalar/' . $this -> seciliTema . '/mesaj.php');
  }
  
  /**
   * Afilli bir hata mesajı
   */
  function hataMesaji($mesaj) {
    require(anaKlasor . '/temalar/' . $this -> seciliTema . '/hataMesaji.php');
  }
  
  /**
   * Modülleri moduller/ klasöründen toplar ve bir dizi olarak döndürür.
   * 
   * @return Dönen değeri $moduller değişkenine aldığımızı varsayarsak
   * 	$moduller[0]['ad']: Modülün tam adı
   * 	$moduller[0]['kisaAd']: Kısa adı
   * 	$moduller[1]['ad']: 
   * 	$moduller[1]['kisaAd']: 
   * 	...
   */
  function moduller() {
    foreach ( scandir(anaKlasor . '/moduller') as $bulunanModul ) {
      if ( pathinfo($bulunanModul, PATHINFO_EXTENSION) == 'php') { // tek dosyalı modül
	$modul['ad'] = $this -> modulAdi(anaKlasor . '/moduller/' . $bulunanModul);
	$modul['kisaAd'] = pathinfo($bulunanModul, PATHINFO_FILENAME);
      }
      else if ( file_exists(anaKlasor . '/moduller/' . $bulunanModul . '/' . $bulunanModul . '.php') ) {
	$modul['ad'] = $this -> modulAdi(anaKlasor . '/moduller/' . $bulunanModul . '/' . $bulunanModul . '.php');
	$modul['kisaAd'] = $bulunanModul;
      }
      else
	continue;
      $moduller[] = $modul;
    }
    return $moduller;
  }
  
  /**
   * Dosya ismi verilen modülün tam adını döndürür
   * 
   * @p dosya: modül dosyasının tam yolu
   */
  function modulAdi($dosya) {
    $oku = file_get_contents($dosya);
    preg_match('#baslik:(.*?)\n#si', $oku, $baslik);
    return trim($baslik[1]);
  }
  
  /**
   * <ul></ul> tagları ile bir menü çıktılar
   */
  function menu() {
    /// Modülleri listele
    $moduller = $this -> moduller();
    echo '<ul>';
      echo '<li><a href="' . siteAdresi . '">Anasayfa</a></li>';
      echo '<li><a href="#">Modlüller</a>';
	echo '<ul>';
	foreach ( $moduller as $modul ) {
	  echo '<li>';
	  echo '<a href="' . siteAdresi . '/modul.php?modul=' . $modul['kisaAd'] . '">' . $modul['ad'] . '</a>';
	  echo '</li>';
	}
	echo '</ul>';
      echo '</li>';
      echo '<li><a href="' . siteAdresi . '/ayar.php">Ayarlar</a></li>';
    echo '</ul>';
  }
  
  /**
   * Veritabanında veri tutmak için kullanılır. 
   * 
   * veri yoksa yeni kayıt yapar
   * veri varsa günceller
   * 
   * @p veriAdi: Veriniz için benzersiz bir isim. @warning Bu isim diğer modüllerle vs. çakışmaması gerekir
   * @p veri: Tutulacak veri. Veri herhangi bir tipte olabilir (string, integer gibi...) @warning resource tipindeki veriler tutulamaz.
   */
  function ayarKaydet($veriAdi, $veri) {
    $veri = serialize($veri);
    
    if ( !$this -> kayitOku("SELECT no FROM ayarlar WHERE ad = '{$veriAdi}'") ) { // Kayıt yoksa ekle
      $ekle = $this -> kayitEkle("INSERT INTO ayarlar (ad, veri) VALUES ('{$veriAdi}', '{$veri}')");
      if ( $ekle === false )
	$this -> hataMesaji('Ayar eklenirken hata oluştu. ');
    }
    else { // Kayıt varsa güncelle
      $guncelle = $this -> kayitGuncelle("UPDATE ayarlar SET veri = '{$veri}' WHERE ad = '{$veriAdi}'");
      if ( $guncelle === false )
	$this -> hataMesaji('Ayar güncellenirken hata oluştu. ');
    }
  }
  
  /**
   * Daha önce kaydedilmiş bir veriyi okur. 
   * 
   * @p veriAdi: okunacak verinin kaydederken kullandığınız adı
   * 
   * @return Veri yoksa false döndürür
   */
  function ayarOku($veriAdi) {
    $oku = $this -> kayitOku("SELECT veri FROM ayarlar WHERE ad = '{$veriAdi}'");
    if ( $oku == false )
      return false;
    return unserialize($oku['veri']);
  }
  
  /**
   * Daha önce kaydedilmiş bir veriyi siler
   * 
   * @p veriAdi: silinecek verinin kaydederken kullandığınız adı
   */
  function ayarSil($veriAdi) {
    if ( $this -> kayitSil("DELETE FROM ayarlar WHERE ad = '{$veriAdi}'") === false )
      $this -> hataMesaji('Ayar silinirken hata oluştu. ');
  }
}
?>