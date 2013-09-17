<?php
require_once('ayarlar.php');
require_once(anaKlasor . '/kutuphane/harici/PHP-SQL-Parser/php-sql-parser.php');

/**
 * Veritabanı işlemlerinde kullanılan sınıf
 * 
 * @todo php-sql-creator.php var. O ne işe yarıyor?
 */
class veritabani extends PHPSQLParser {
  
  private $baglanti = null;
  
  function __construct() {
    parent::__construct();
  }
  
  /**
   * Sql sunucusuna bağlantı kurar
   * 
   * @note hiçbir parametre verilmezse ayarlar.php`deki ayarları kullanarak bir bağlantı kurar.
   * @p server: sql sunucusunun adresi
   * @p username: kullanıcı adı
   * @p password: şifre
   * @p db: seçilecek veritabanı
   * 
   * @todo bu fonksiyondan birşeyler dönmesi lazım. hata durumunda false falan...
   */
  function baglan($server = sqlSunucu, $username = sqlUser, $password = sqlPass, $db = sqlDB) {
    $this -> baglanti = mysql_connect($server, $username, $password);
    mysql_select_db($db);
    mysql_query("SET NAMES 'utf8'");
  }
  
  /**
   * Verilen sql sorgusunu çalıştırıp sonucunu döndürür
   * 
   * @p sql: SQL metni
   * 
   * @warning Hiçbir güvenlik önlemi almadan sorguyu direk çalıştırır. 
   */
  function sqlSorgusuCalistir($sql) {
    if ( $this -> baglanti == null ) // Bağlantı kurulmamışsa bağlantı kur.
      $this -> baglan();
    
    $donenSonuc = mysql_query($sql, $this -> baglanti);
    return $donenSonuc;
  }
  
  /**
   * Verilen bir SELECT metni ile veritabanından kayıt okur
   * @note Gerekli güvenlik önlemlerini alır.
   * 
   * @p SELECTMetni: SELECT ile başlayan bir SQL metni
   * 
   * @return 
   * birden fazla kayıt döndüyse: $satirlar[0]['sutun1']
   * 				  $satirlar[0]['sutun2']
   * 				  ...
   * 				  $satirlar[1]['sutun1']
   * 				  $satirlar[1]['sutun2']
   * 				  ...
   * tek kayıt döndüyse: $satirlar['sutun1']
   * 			 $satirlar['sutun2']
   * 			 ...
   * hiç kayıt dönmezse: false
   * 
   * @todo Bu fonksiyonu değişik SQL sorguları ile deneyip geliştirmek lazım. Şuanki hali ile karmaşık sorgularda sorun çıkarabilir. 
   */
  function kayitOku($SELECTMetni) {
    /// Verilen SELECT deyimini parçala ve temizlik fonksiyonundan geçir
    $sqlParcalari = $this -> parse($SELECTMetni);
    $temizSQL = '';
    while ( $parca = each($sqlParcalari) )
      switch ( $parca['key'] ) {
	case 'SELECT':
	  $temizSQL .= 'SELECT ';
	  $parca = $parca['value'];
	  $ilkDeyim = true;
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'colref':
		$temizSQL .= ( ($ilkDeyim) ? '' : ',' ) . $this -> sqlTemizle($deyim['base_expr']);
		$ilkDeyim = false;
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	case 'FROM':
	  $temizSQL .= ' FROM ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'table':
		$temizSQL .= $this -> sqlTemizle($deyim['base_expr']);
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	case 'WHERE':
	  $temizSQL .= ' WHERE ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'colref':
		$temizSQL .= $this -> sqlTemizle($deyim['base_expr']);
	      break;
	      case 'operator':
		$temizSQL .= " {$deyim['base_expr']} ";
	      break;
	      case 'const':
		$tirnakYok = false;
		if ( trim($deyim['base_expr'], "'") == $deyim['base_expr'] )
		  $tirnakYok = true;
		$geciciConst = $this -> sqlTemizle(trim($deyim['base_expr'], "'"));
		if ( !$tirnakYok )
		  $geciciConst = $this -> tekTirnak($geciciConst);
		$temizSQL .= $geciciConst;
		unset($geciciConst);
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	default:
	  echo "{$parca['key']} anahtarı tanınmıyor. ";
      }
    
    $donenSonuc = $this -> sqlSorgusuCalistir($temizSQL);
    while ( $satir = mysql_fetch_array($donenSonuc, MYSQL_ASSOC) ) {
      $satirlar[] = $satir;
    }
    if ( !isset($satirlar) ) // Hiç kayıt dönmemişse
      $satirlar = false;
    else if ( count($satirlar) == 1 ) // Tek kayıt döndüyse
      $satirlar = $satirlar[0];
    
    return $satirlar;
  }
  
  /**
   * Veritabanına kayıt ekler. 
   * @p INSERTMetni: INSERT INTO ile başlayan bir sql metni
   * 
   * @return
   * Eğer sorgu başarıyla çalıştırılırsa etkilenen kayıt sayısı döner.
   * Eğer sorgu çalıştırılamazsa false döner.
   * 
   * @todo karmaşık sorgulara uygun şekilde geliştirmek lazım
   */
  function kayitEkle($INSERTMetni) {
    $sqlParcalari = $this -> parse($INSERTMetni);
    $temizSQL = '';
    while ( $parca = each($sqlParcalari) )
      switch ( $parca['key'] ) {
	case 'INSERT':
	  $temizSQL .= 'INSERT INTO ';
	  $parca = $parca['value'];
	  $temizSQL .= $parca['table'] . ' (';
	  $ilkSutun = true;
	  foreach ( $parca['columns'] as $sutun ) {
	    $temizSQL .= (($ilkSutun) ? '' : ',') . $this -> sqlTemizle($sutun['base_expr']);
	    $ilkSutun = false;
	  }
	  $temizSQL .= ')';
	break;
	case 'VALUES':
	  foreach( $parca['value'] as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'record';
		$temizSQL .= ' VALUES (';
		foreach( $deyim['data'] as $data ) {
		  $data['base_expr'] = trim($data['base_expr'], "'");
		  $data['base_expr'] = $this -> sqlTemizle($data['base_expr']);
		  if ( !is_numeric($data['base_expr']) )
		    $data['base_expr'] = $this -> tekTirnak($data['base_expr']);
		  
		  $temizSQL .= $data['base_expr'] . ',';
		}
		$temizSQL = rtrim($temizSQL, ',') . ')';
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	default:
	  echo "{$parca['key']} anahtarı tanınmıyor. ";
      }
    
    $donenSonuc = $this -> sqlSorgusuCalistir($temizSQL);
    if ( $donenSonuc )
      return mysql_affected_rows($this -> baglanti);
    else
      return $donenSonuc;
  }
  
  /**
   * Veritabanında kayıt güncellemek için kullanılır. 
   * @p UPDATEMetni: UPDATE ile başlayan bir sql metni
   * 
   * @return
   * Eğer sorgu başarıyla çalıştırılırsa etkilenen kayıt sayısı döner.
   * Eğer sorgu çalıştırılamazsa false döner.
   * 
   * @todo karmaşık sorgulara uygun şekilde geliştirmek lazım
   */
  function kayitGuncelle ($UPDATEMetni) {
    $sqlParcalari = $this -> parse($UPDATEMetni);
    $temizSQL = '';
    while ( $parca = each($sqlParcalari) )
      switch ( $parca['key'] ) {
	case 'UPDATE':
	  $temizSQL .= 'UPDATE ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'table':
		$temizSQL .= $this -> sqlTemizle($deyim['base_expr']);
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	case 'SET':
	  $temizSQL .= ' SET ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim ) {
	    switch ( $deyim['expr_type'] ) {
	      case 'expression':
		foreach ( $deyim['sub_tree'] as $subtree ) 
		  switch ( $subtree['expr_type'] ) {
		    case 'colref':
		      $temizSQL .= $this -> sqlTemizle($subtree['base_expr']);
		    break;
		    case 'operator':
		      $temizSQL .= $subtree['base_expr'];
		    break;
		    case 'const':
		      $subtree['base_expr'] = trim($subtree['base_expr'], "'");
		      $subtree['base_expr'] = $this -> sqlTemizle($subtree['base_expr']);
		      if ( !is_numeric($subtree['base_expr']) )
			$subtree['base_expr'] = $this -> tekTirnak($subtree['base_expr']);
		      $temizSQL .= $subtree['base_expr'];
		    break;
		    default:
		      echo "{$subtree['expr_type']} tipi tanınmıyor. ";
		  }
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	    $temizSQL .= ',';
	  }
	  $temizSQL = rtrim($temizSQL, ',');
	break;
	case 'WHERE':
	  $temizSQL .= ' WHERE ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'colref':
		$temizSQL .= $this -> sqlTemizle($deyim['base_expr']);
	      break;
	      case 'operator':
		$temizSQL .= " {$deyim['base_expr']} ";
	      break;
	      case 'const':
		$tirnakYok = false;
		if ( trim($deyim['base_expr'], "'") == $deyim['base_expr'] )
		  $tirnakYok = true;
		$geciciConst = $this -> sqlTemizle(trim($deyim['base_expr'], "'"));
		if ( !$tirnakYok )
		  $geciciConst = $this -> tekTirnak($geciciConst);
		$temizSQL .= $geciciConst;
		unset($geciciConst);
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	default:
	  echo "{$parca['key']} anahtarı tanınmıyor. ";
      }
      
    $donenSonuc = $this -> sqlSorgusuCalistir($temizSQL);
    if ( $donenSonuc )
      return mysql_affected_rows($this -> baglanti);
    else
      return $donenSonuc;
  }
  
  /**
   * Veritabanından kayıt silmek için kullanılır.
   * 
   * @p DELETEMetni: DELETE FROM ile başlayan bir sql metni
   * 
   * @return
   * Eğer sorgu başarıyla çalıştırılırsa etkilenen kayıt sayısı döner.
   * Eğer sorgu çalıştırılamazsa false döner.
   */
  function kayitSil($DELETEMetni) {
    $sqlParcalari = $this -> parse($DELETEMetni);
    $temizSQL = '';
    while ( $parca = each($sqlParcalari) )
      switch ( $parca['key'] ) {
	case 'DELETE':
	  $temizSQL .= 'DELETE ';
	break;
	case 'FROM':
	  $temizSQL .= 'FROM ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'table':
		$temizSQL .= $this -> sqlTemizle($deyim['base_expr']);
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	case 'WHERE':
	  $temizSQL .= ' WHERE ';
	  $parca = $parca['value'];
	  foreach ( $parca as $deyim )
	    switch ( $deyim['expr_type'] ) {
	      case 'colref':
		$temizSQL .= $this -> sqlTemizle($deyim['base_expr']);
	      break;
	      case 'operator':
		$temizSQL .= " {$deyim['base_expr']} ";
	      break;
	      case 'const':
		$tirnakYok = false;
		if ( trim($deyim['base_expr'], "'") == $deyim['base_expr'] )
		  $tirnakYok = true;
		$geciciConst = $this -> sqlTemizle(trim($deyim['base_expr'], "'"));
		if ( !$tirnakYok )
		  $geciciConst = $this -> tekTirnak($geciciConst);
		$temizSQL .= $geciciConst;
		unset($geciciConst);
	      break;
	      default:
		echo "{$deyim['expr_type']} tipi tanınmıyor. ";
	    }
	break;
	default:
	  echo "{$parca['key']} anahtarı tanınmıyor. ";
      }
      
    $donenSonuc = $this -> sqlSorgusuCalistir($temizSQL);
    if ( $donenSonuc )
      return mysql_affected_rows($this -> baglanti);
    else
      return $donenSonuc;
  }
  
  /**
   * Verilen string in başına ve sonuna ' atar
   */
  function tekTirnak ($string) {
    return '\''. $string . '\'';
  }
  
  /** 
   * İstemciden gelen verileri temizlemek için
   */
  function sqlTemizle ($veri) {
    if ( $this -> baglanti == null ) // Bağlantı kurulmamışsa bağlantı kur.
      $this -> baglan();
    
    return mysql_real_escape_string($veri, $this -> baglanti);
  }
}
?>