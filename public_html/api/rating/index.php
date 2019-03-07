<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use CapstoneTrails\AbqTrails\{
	Rating, Profile, Trail
};


/**
 * api for trail tag class
 *
 * @author Robert Dominguez <rdominguez45@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mysql connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize the inputs
	$ratingProfileId = $id = filter_input(INPUT_GET, "ratingProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$ratingTrailId = $id = filter_input(INPUT_GET, "ratingTrailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	//process actual GET and POST methods
	if($method === "GET") {
		//set XSRF token
		setXsrfCookie();

		//get a rating by id and update reply
		if($ratingProfileId !== null && $ratingTrailId !== null) {
			$rating = Rating::getRatingByRatingProfileIdAndRatingTrailId($pdo, $ratingProfileId, $ratingTrailId);
			if($rating !== null) {
				$reply->data = $rating;
			}

			//if none of the search parameters are met throw an exception
		} else if(empty($ratingProfileId) === false) {
			$reply->data = Rating::getRatingByRatingProfileId($pdo, $ratingProfileId);
		} else if(empty($ratingTrailId) === false) {
			$reply->data = Rating::getRatingByRatingTrailId($pdo, $ratingTrailId);
		} else {
		throw new InvalidArgumentException("incorrect search parameters ", 404);
	}

	} else if($method === "POST") {
		// enforce the user has a XSRF token

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

		if($method === "POST") {

			//verify Xsrf
			verifyXsrf();

			//enforce the user is signed in to tag the trail
			if(empty($_SESSION ["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to tag a trail", 403));
			}

			validateJwtHeader();

			$rating = new Rating($_SESSION["profile"]->getProfileId(), $requestObject->ratingTrailId, $requestObject->ratingDifficulty, $requestObject->ratingValue);
			$rating->insert($pdo);

			//rating reply
			$reply->message = "Rating added";
		}
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
echo json_encode($reply);