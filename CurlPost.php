<?php
/**
 * 
 * @author: hanwf 2016年9月19日
 */
function post( $url, $data) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$response = curl_exec($ch);
	$errno    = curl_errno($ch);
	curl_close($ch);
	
	if ($errno != 0) {
		echo( "post errno=$errno response=$response");
		return false;
	}
	
	return $response;
}

$url = "";
$data = array(
		
);

$data = json_encode($data);
$result = post($url, $data);


