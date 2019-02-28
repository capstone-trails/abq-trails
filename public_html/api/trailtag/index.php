<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
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
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
		$pdo = $secrets->getPdoObject();

		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

		//sanitize the search parameters

		//		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
		$trailTagTagId = $id = filter_input(INPUT_GET, "trailTagTagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$trailTagTrailId = $id = filter_input(INPUT_GET, "trailTagTrailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$trailTagProfileId = filter_input(INPUT_GET, "trailTagProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(($method === "DELETE") && (empty($id) === true)){
			throw(new \InvalidArgumentException("Id cannot be empty", 405));
			}

		if($method === "POST") {
			// enforce the user has a XSRF token
			verifyXsrf();
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
			if(empty($requestObject->trailTagProfileId) === true) {
				throw (new \InvalidArgumentException("No profile linked to the trail tag", 405));
			}
			//enforce the user is signed in to tag the trail
			if(empty($_SESSION ["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to tag a trail", 403));
			}

			$trailTag = new TrailTag($requestObject->trailTagTagId, $requestObject->trailTagTrailId, $_SESSION["profile"]->getProfileId);
			$trailTag->insert($pdo);

			//tag reply
			$reply->message = "Tag added to trail";


		} else if($method === "DELETE") {

			//enforce that the end user has a XSRF token.
			verifyXsfr();

			//get the trail tag that needs to be deleted

			$trailTag = TrailTag::getTrailTagByTrailTagTagIdAndTrailTagTrailId($pdo, $requestObject->trailTagTagId, $requestObject->trailTagTrailId);
			if($trailTag === null) {
				throw (new RuntimeException("Trail tag does not exist", 404));
			}

			//enforce that the user is signed in to un-tag the trail
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $trailTag->getTrailTagProfileId()) {
				throw(new \InvalidArgumentException("Whoops! You are not allowed to un-tag this", 403));
			}
			$trailTag->delete($pdo);

			$reply->message = "Trail tag removed";
		}
			// update the $reply->status $reply->message
		}catch(\Exception | \TypeError $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
}
		// encode and return reply to front end caller
		header("Content-type: application/json");
		echo json_encode($reply);