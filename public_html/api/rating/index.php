<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use CapstoneTrails\AbqTrails\{Profile, Trail};


/**
 * api for trail tag class
 *
 * @author Robert Dominguez <rdominguez45@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// verify the session, start if not active
if (session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQl connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/rating.ini");
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/rating.ini");

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$ratingProfileId = $id = filter_input(INPUT_GET, "ratingProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$ratingTrailId = $id = filter_input(INPUT_GET, "ratingTrailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if(($method === "DELETE") && (empty($id) === true)){
		throw(new \InvalidArgumentException("Id cannot be empty", 405));
	}

	//process actual GET and POST methods
	if($method === "GET") {
		//set XSRF token
		setXsrfCookie();

		//get a rating by id and update reply
		if(empty($id) === false) {
			$rating = Rating::getRatingByRatingProfileIdAndRatingTrailId($pdo, $id);
		} else if(empty($ratingProfileId) === false) {
			$reply->data = Rating::getRatingByRatingProfileId($pdo, $ratingProfileId)->toArray();
		} else if(empty($ratingTrailId) === false) {
			$reply->data = Rating::getRatingByRatingTrailId($pdo, $ratingTrailId)->toArray();
		}
	} else if($method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();
		//Retrieve the Json package and store in $requestContent
		$requestContent = file_get_contents("php://input");
		// Decode the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->ratingProfileId) === true) {
			throw (new \InvalidArgumentException("No profile linked to the rating", 405));
		}
		if(empty($requestObject->ratingTrailId) === true) {
			throw (new \InvalidArgumentException("No trail linked to the rating", 405));
		}
		//enforce the user is signed in to tag the trail
		if(empty($_SESSION ["profile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to tag a trail", 403));
		}

		$rating = new Rating($requestObject->ratingProfileId, $requestObject->ratingTrailId, $_SESSION["profile"]->getProfileId);
		$rating->insert($pdo);

		//rating reply
		$reply->message = "rating added";


	}
}catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
echo json_encode($reply);