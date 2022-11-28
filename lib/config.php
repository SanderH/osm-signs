<?php
/* This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

/*
DEV:
https://master.apis.dev.openstreetmap.org/user/<user>/oauth_clients/<id>
$req_url = 'https://master.apis.dev.openstreetmap.org/oauth/request_token';
$authurl = 'https://master.apis.dev.openstreetmap.org/oauth/authorize';
$acc_url = 'https://master.apis.dev.openstreetmap.org/oauth/access_token';
$api_url = 'http://master.apis.dev.openstreetmap.org/api/0.6';
$conskey = '';
$conssec = '';
*/

/*
https://openstreetmap.org/user/<user>/oauth_clients/<id>
PROD:
*/
$req_url = 'http://www.openstreetmap.org/oauth/request_token';     // OSM Request Token URL
$authurl = 'http://www.openstreetmap.org/oauth/authorize';         // OSM Authorize URL
$acc_url = 'http://www.openstreetmap.org/oauth/access_token';      // OSM Access Token URL
$api_url = 'http://api.openstreetmap.org/api/0.6/';                // OSM API URL
$conskey = '';
$conssec = '';

// Details of the logged-in user: $api_url/user/details

/*
$host = '${DB_HOST}';
$user = '${DB_USER}';
$pass = '${DB_PASS}';
$db   = '${DATABASE}';

$connection = pg_pconnect('host='.$host.' port=5432 dbname='.$db.' user='.$user.' password='.$pass);
pg_query($connection, 'SET search_path TO oauth');
*/

require $_SERVER['DOCUMENT_ROOT'].'/lib/signs.php';
?>