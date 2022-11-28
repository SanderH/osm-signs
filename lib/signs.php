<?php

$signs_users = array("Sander H");

$osm_id;
$osm_user;

function isSignsUser()
{
	global $signs_users;
	global $osm_user;
	
	if (!isset($osm_user)) { return FALSE; }
	
	if (isLoggedIn())
	{	
		return in_array($osm_user, $signs_users);
	}
	else
	{
		return FALSE;
	}
}

function isLoggedIn()
{
	global $conskey,$conssec;
	global $api_url;
	global $osm_user, $osm_id;
	
	if (!isset($_COOKIE['token']) && !isset($_COOKIE['secret']))
	{
		return FALSE;
	};
	if (isset($osm_user))
	{
		return TRUE;
	}
	
	try {
		$oauth = new OAuth($conskey,$conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
		$oauth->enableDebug();
		$oauth->setToken($_COOKIE['token'],$_COOKIE['secret']);
		$oauth->fetch("$api_url/user/details");
		$xml = simplexml_load_string($oauth->getLastResponse());
//		var_dump($xml);
		
		$osm_id = $xml->user["id"];
		$osm_user = $xml->user["display_name"];
		
//		var_dump($osm_user);
		return TRUE;
	} catch(OAuthException $E) {
		//print_r($E);
		if ($E->getCode() == 401)
		{
			Header("Location: /authenticate.php?action=revoked");
		}
	}
}
?>