<?php
/**
* Çalıntı wordpress temaları bulmaya yarayan bir modüldür.
* 
* baslik: Warez Tema Tespit Aracı
*/
$webmasterPanel -> jsYukle('jquery-1.10.2.min.js');
$webmasterPanel -> jsYukle(siteAdresi.'/moduller/warez-tema-tespit/functions.js');
$webmasterPanel -> cssYukle(siteAdresi.'/moduller/warez-tema-tespit/style.css');
?>	
<div id="wtb">
	<div id="aciklama">
		İlk kutucuğa temanın bulunduğu demonun adresi yazılacak. <strong>Örnek:</strong> http://burakisci.com/?themedemo=burakisciv4 <br/>
		İkinci kutucuğa ise temanın satıldığı sitelerin domainleri yazaılacak. Bu kısım zorunlu değil, burası sadece arama sonuçlarında satın alan domainler çıkmasın diye konuldu.
	</div>
	<div id="url">
		<label for="user_city">Tema Adresi: </label>
		<input class="user_city" type="user_city" value="" placeholder="Temanın demo url'sini girin " size="45"/>
	</div>
	<div id="siteler">
		<label for="siteler">Tema Satılan Siteler: </label>
		<textarea name="siteler" class="siteler" cols="45" rows="6" placeholder="Her satıra bir adres girilecek şekilde yazın" ></textarea>
	</div>
	<div id="sub">
		<input type="submit" name="submit" id="submit" class="button" value="SORGULA" />
	</div>
	<br/><br/>
		<br/><br/>
	<br/>
	<div id="sonuc"></div>
</div>