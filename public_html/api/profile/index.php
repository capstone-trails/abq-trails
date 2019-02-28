<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use CapstoneTrails\AbqTrails\Profile;

/**
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.02 - original author George Kephart
 **/

//verify the session, if it is not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mysql connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/trails.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

}
