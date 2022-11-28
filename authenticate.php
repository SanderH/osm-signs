<?php
require $_SERVER['DOCUMENT_ROOT'].'/lib/config.php';

if (!isset($_GET['action'])) {
    $_GET['action'] = 'login';
}

switch ($_GET['action']) {

case 'login':

    // Go to actual auth script
    Header("Location: /auth_osm.php");
    break;

case 'logout':
case 'revoked':

	// clear cookies with access information, token on https://openstreetmap.org/user/<user>/oauth_clients will remain, but becomes unusable without these cookies
	setcookie('token', '', time()-3600, '/', 'signs.tools4osm.nl', TRUE);
    setcookie('secret', '', time()-3600, '/', 'signs.tools4osm.nl', TRUE);

    Header("Location: /");
    break;

case 'success':

    Header("Location: /");
    break;

default:
	// send them back to homepage
    Header("Location: /");
}

?>