<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use CapstoneTrails\AbqTrails\{Trail, Profile};

/**
 * api for Trail class
 *
 * @author Scott Wells <swells19@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mysql connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$pdo = $secrets->getPdoObject();

	//determine which GTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$trailAvatarUrl = filter_input(INPUT_GET, "trailAvatarUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$trailDescription = filter_input(INPUT_GET, "trailDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$trailHigh = filter_input(INPUT_GET, "trailHigh", FILTER_SANITIZE_NUMBER_INT);
	$trailLatitude = filter_input(INPUT_GET, "trailLatitude", FILTER_SANITIZE_NUMBER_FLOAT);
	$trailLength = filter_input(INPUT_GET, "trailLength", FILTER_SANITIZE_NUMBER_FLOAT);
	$trailLongitude = filter_input(INPUT_GET, "trailLongitude", FILTER_SANITIZE_NUMBER_FLOAT);
	$trailLow = filter_input(INPUT_GET, "trailLow", FILTER_SANITIZE_NUMBER_INT);
	$trailName = filter_input(INPUT_GET, "trailName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


}