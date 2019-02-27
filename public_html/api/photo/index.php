<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");

use CapstoneTrails\AbqTrails\Photo;

/**
 * Cloudinary API for image upload
 *
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.02 updated from Brent Kie & Marty Boncacci
 **/

//start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mysql connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/trails.ini");

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize inputs
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$config = readConfig("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config([
		"cloud_name" => $cloudinary->cloudName,
		"api_key" => $cloudinary->apiKey,
		"api_secret" => $cloudinary->apiSecret
	]);

	//make sure the id is valid for methods that require it
	if($method === "POST") {
		//verify that the end user has XSRF token
	}



}