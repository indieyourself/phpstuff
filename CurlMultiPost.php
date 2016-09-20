<?php
/**
 * 
 * @author: hanwf 2016年9月20日
 */
function multipost( $url, $data, $num) {
	$mch = curl_multi_init();
	
	$chs = array();
	
	for( $i=0; $i < $num; ++$i) {
		$chs[$i] = curl_init($url);
		curl_setopt($chs[$i], CURLOPT_POST, true);
		curl_setopt($chs[$i], CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($chs[$i], CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($chs[$i], CURLOPT_POSTFIELDS, $data);
		curl_setopt($chs[$i], CURLOPT_TIMEOUT, 300);
		curl_setopt($chs[$i], CURLOPT_CONNECTTIMEOUT, 300);
		curl_setopt($chs[$i], CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chs[$i], CURLOPT_FOLLOWLOCATION, true);
		
		curl_multi_add_handle($mch, $chs[$i]);
	}
	
	$active = null;
	do {
		$mrc = curl_multi_exec($mch, $active);
		curl_multi_select($mch);
	} while($active > 0 );
	
	foreach ( $chs as$ch ) {
		$response = curl_multi_getcontent($ch);
		$errno    = curl_errno($ch);
		if ($errno != 0) {
			echo( "post errno=$errno response=$response");
		}
		
		curl_multi_remove_handle($chs, $ch);
	}
	
	curl_multi_close($mch);
}

$url = "http://192.168.10.92:8083/bc/log?_t=123456&_v=1.0&_os=1&channel=99999";
$data = array(

);

$data = json_encode($data);
$result = multipost($url, $data, 100);

