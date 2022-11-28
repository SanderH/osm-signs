<?php

require $_SERVER['DOCUMENT_ROOT'].'/lib/config.php';

session_start();

if(!isset($_GET['oauth_token']) && (!isset($_SESSION['state']) || $_SESSION['state']==1)) $_SESSION['state'] = 0;
try {
	$oauth = new OAuth($conskey,$conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
	$oauth->enableDebug();
	if(!isset($_GET['oauth_token']) && !$_SESSION['state']) {
		$request_token_info = $oauth->getRequestToken($req_url);
		$_SESSION['secret'] = $request_token_info['oauth_token_secret'];
		$_SESSION['state'] = 1;
		header('Location: '.$authurl.'?oauth_token='.$request_token_info['oauth_token']);
		exit;
	} else if($_SESSION['state']==1) {
		$oauth->setToken($_GET['oauth_token'],$_SESSION['secret']);
		$access_token_info = $oauth->getAccessToken($acc_url, '', $_GET['oauth_verifier']);
		$_SESSION['state'] = 2;

		// create cookies with OSM tokens to expire in 10 years
		setcookie('token', $access_token_info['oauth_token'], time() + (10 * 365 * 24 * 60 * 60), '/', 'signs.tools4osm.nl', TRUE);
		setcookie('secret', $access_token_info['oauth_token_secret'], time() + (10 * 365 * 24 * 60 * 60), '/', 'signs.tools4osm.nl', TRUE);

		session_unset();
		session_destroy();
	} 
/*
	$oauth->setToken($access_token_info['oauth_token'],$access_token_info['oauth_token_secret']);
	$oauth->fetch("$api_url/user/details");
	$xml = simplexml_load_string($oauth->getLastResponse());
*/
    Header("Location: /");
} catch(OAuthException $E) {
	print_r($E);
}
?>