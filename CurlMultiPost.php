<?php
/**
 * 
 * @author: hanwf 2016年9月20日
 */
function multipost( $url, $data, $num) {
	$mch = curl_multi_init();
	
	$ch = array();
	
	for( $i=0; $i < $num; ++$i) {
		$ch[$i] = curl_init($url);
		curl_setopt($ch[$i], CURLOPT_POST, true);
		curl_setopt($ch[$i], CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch[$i], CURLOPT_TIMEOUT, 300);
		curl_setopt($ch[$i], CURLOPT_CONNECTTIMEOUT, 300);
		curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, true);
		
		curl_multi_add_handle($mch, $ch[$i]);
	}
	
	$still_running = null;
	do {
		$mrc = curl_multi_exec($mch, $still_running);
	} while($still_running );
	
	foreach ( $mch as $i => $ch ) {
		$response = curl_multi_getcontent($ch);
		$errno    = curl_errno($ch);
		if ($errno != 0) {
			echo( "post errno=$errno response=$response");
		}
	}
	
	foreach ( $mch as $ch ) {
		curl_multi_remove_handle($mch, $ch);
	}
	
	curl_multi_close($mch);
}

$url = "http://192.168.10.92:8083/bc/log?_t=123456&_v=1.0&_os=1&channel=99999";
$data = array(

);

$data = json_encode($data);
$result = multipost($url, $data, 100);

