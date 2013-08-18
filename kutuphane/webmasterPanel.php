<?php
require_once('ayarlar.php');
ob_start();

/**
 * Webmaster Panel Nesnesi
 */
class webmasterPanel {
  
  /**
   * Özellik tanımlamaları
   */
  
  /// temalar klasöründeki tema klasorünün ismi
  public $seciliTema = 'webmasterPanel';
  
  /// html çıktısında head içine bu değişken yazılır. 
  private $html_head = '';
  
  /**
   * Temayı yükleyip html çıktısını verir. 
   */
  function htmlCiktisiVer() {
    $orta = ob_get_contents();
    ob_end_clean();
    
    require(anaKlasor . 'temalar/' . $this -> seciliTema . '/ust.php');
    
    echo $orta;
    
    require(anaKlasor . 'temalar/' . $this -> seciliTema . '/alt.php');
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
    $this -> headEkle('<link type="text/css" href="' . ( (preg_match('#^http://*#i', $css)) ? $css : siteAdresi . 'css/' . $css ) . '" rel="styleSheet" />');
  }
  
  /**
   * head bölümünde javascript çağırır.
   * @p $js: http:// ile başlamazsa js/ dizininden çağırır
   * @warning htmlCiktisiVer fonksiyonu çalışmadan önce çağrılması gerekir
   */
  function jsYukle($js) {
    $this -> headEkle('<script src="' . ( (preg_match('#^http://*#i', $js)) ? $js : siteAdresi . 'js/' . $js ) . '" type="text/javascript"></script>');
  }
  
  /**
   * Afilli bir hata mesajı
   */
  function hataMesaji($mesaj) {
    require(anaKlasor . 'temalar/' . $this -> seciliTema . '/hataMesaji.php');
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
    foreach ( scandir(anaKlasor . 'moduller') as $bulunanModul ) {
      if ( pathinfo($bulunanModul, PATHINFO_EXTENSION) == 'php') { // tek dosyalı modül
	$modul['ad'] = $this -> modulAdi(anaKlasor . 'moduller/' . $bulunanModul);
	$modul['kisaAd'] = pathinfo($bulunanModul, PATHINFO_FILENAME);
      }
      else if ( file_exists(anaKlasor . 'moduller/' . $bulunanModul . '/' . $bulunanModul . '.php') ) {
	$modul['ad'] = $this -> modulAdi(anaKlasor . 'moduller/' . $bulunanModul . '/' . $bulunanModul . '.php');
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
  
}
?>