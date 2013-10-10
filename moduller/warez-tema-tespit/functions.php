<?php
function filtrele($outfiltresiz) {
	
	GLOBAL $filtre;
	$outfiltreli = array();
	
	foreach ( $outfiltresiz as $a ) {
	
		$j = true;
		foreach ( $filtre as $b ) {

			if ( preg_match($b, $a) ) { 
			
				$j = false;
				
			}
			
		}
		
		if ( $j ) { $outfiltreli[] = $a; }
		
	}
	
	return $outfiltreli;

}
function gsearch($img,$page) {
	
	GLOBAL $urlarray;
	
	$url = 'http://ajax.googleapis.com/ajax/services/search/images?v=1.0&start='.(($page-1)*4).'&q=inurl:wp-content/themes/?/'.$img;

	$json = curl($url);
	$json = json_decode($json,true);
	
	foreach ( $json['responseData']['results'] as $a => $b) {
	
		$url = parse_url($b['url']);
		$url = $url['host'];

		$urlarray[] = $url;
	
	}
	
	return true;

}
function curl($url) {

	GLOBAL $user_city;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_REFERER, $user_city);
	$body = curl_exec($ch);
	curl_close($ch);

	return $body;

}
function site_cikart($a,$b) {

	$b = explode("\n", $b);
	//print_R($b);
	$b_dom = array();
	foreach ( $b as $c ) {
		
		if ( !preg_match("/^http\:\/\//",$c,$sonuc) and !preg_match("/^https\:\/\//",$c,$sonuc) ) 	{ $c = 'http://'.$c; }
		$c = parse_url($c);
		$b_dom[] = $c['host'];
	
	}
	
	//print_R($b_dom);
	return array_diff($a, $b_dom);
	
}
?>