<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

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
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
		$pdo = $secrets->getPdoObject();

		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

		//sanitize the search parameters

		//		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
		$trailTagTagId = $id = filter_input(INPUT_GET, "trailTagTagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$trailTagTrailId = $id = filter_input(INPUT_GET, "trailTagTrailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$trailTagProfileId = filter_input(INPUT_GET, "trailTagProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


		if($method === "POST" || $method === "PUT") {

			//Retrieve the Json package and store in $requestContent
			$requestContent = file_get_contents("php://input");
			// Decode the JSON package and stores that result in $requestObject
			$requestObject = json_decode($requestContent);

			if(empty($requestObject->trailTagTagId) === true) {
				throw (new \InvalidArgumentException("No tag linked to the trail tag", 405));
			}
			if(empty($requestObject->trailTagTrailId) === true) {
				throw (new \InvalidArgumentException("No trail linked to the trail tag", 405));
			}

			if($method === "POST") {
				//verify xsrf
				verifyXsrf();

				//enforce the user is signed in
				if(empty($_SESSION ["profile"]) === true) {
					throw(new \InvalidArgumentException("You must be logged in to tag a trail", 403));
				}

				//enforce the end user has a JWT token
				validateJwtHeader();

				$trailTag = new TrailTag($_SESSION["profile"]->getProfileId(), $requestObject->trailTagTagId, $requestObject->trailTagTrailId);
				$trailTag->insert($pdo);

				//tag reply
				$reply->message = "Tag added to trail";


			} else if($method === "PUT") {

				//enforce that the end user has a XSRF token.
				verifyXsrf();

				//enforce the end user has a JWT token
				validateJwtHeader();

				//grab the trailtag by its composite key
				$trailTag = TrailTag::getTrailTagByTrailTagTagIdAndTrailTagTrailId($pdo, $requestObject->trailTagTagId, $requestObject->trailTagTrailId);
				if($trailTag === null) {
					throw (new \RuntimeException("Trail tag does not exist", 404));
				}

				//enforce that the user is signed in to un-tag the trail
				if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $trailTag->getTrailTagProfileId()) {
					throw(new \InvalidArgumentException("Whoops! You are not allowed to un-tag this", 403));
				}

				//perform the actual delete
				$trailTag->delete($pdo);

				//update the message
				$reply->message = "Trail tag removed";
			}

			//if any other HTTP request is sent throw an exception
		} else {
			throw(new \InvalidArgumentException("Invalid HTTP request", 400));
		}

		// update the $reply->status $reply->message
	} catch(\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}
	// encode and return reply to front end caller
	header("Content-type: application/json");
	echo json_encode($reply);