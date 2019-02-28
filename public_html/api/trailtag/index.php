<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use CapstoneTrails\AbqTrails\ {
	TrailTag
};

/**
 * api for trail tag class
 *
 * @author Cassandra Romero <cromero278@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
//grab the mySQL connection
	try {
		//grab the mySQL connection
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/trails.ini");

		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
		//sanitize the search parameters
		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
		$trailTagTagId = $id = filter_input(INPUT_GET, "trailTagTagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$trailTagTrailId = $id = filter_input(INPUT_GET, "trailTagTrailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$trailTagProfileId = $id = filter_input(INPUT_GET, "trailTagProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	}