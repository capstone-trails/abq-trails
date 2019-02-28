<?php

	require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
	require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
	require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
	require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
	require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
	require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\AbqTrails\{
	tag, Profile, Trail
};
/**
 * api for the Comment class
 *
 * @author Ronald Luna <ronaldluna1@gmail.com>
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
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/outside.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize the search parameters
	$commentId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
	$commentProfileId = filter_input(INPUT_GET, "tagProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentTrailId = filter_input(INPUT_GET, "tagTrailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a specific tag based on its tagId
		if(empty($commentId) === false) {
			$comment = Tag::getCommentByCommentId($pdo, $commentId);
			if($comment !== null) {
				$reply->data = $tag;
			}
			//get all the comments associated with a profileId
		} elseif(empty($commentProfileId) === false) {
			$comment = Tag::getCommentByCommentProfileId($pdo, $commentProfileId)->toArray();
			if($comment !== null) {
				$reply->data = $tag;
			}
			//get all the comments associated with the trailId
		} elseif(empty($commentTrailId) === false) {
			$comment = Tagt::getCommentByCommentTrailId($pdo, $commentTrailId)->toArray();
			if($comment !== null) {
				$reply->data = $tag;
			}
		} else {
			$reply->data = null;
		}
		/**
		 * Post for tag
		 **/
	} else if($method === "POST") {
		//enforce that the end user has a XSRF token
		verifyXsrf();
		//enforce the end user has a JWT token
//		validateJwtHeader();
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->tagTrailId) === true) {
			throw (new \InvalidArgumentException("no trail linked to the tag", 405));
		}
		if(empty($requestObject->tagContent) === true) {
			throw (new \InvalidArgumentException("You need something to say to say something!", 405));
		}
//		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to comment on a trail", 403));
		}
		$tagId = generateUuidV4();
		$tagTimestamp = new \DateTime();
		$tag = new Tag($tagId,$_SESSION["profile"]->getTagProfileId(), $requestObject->tagTrailId, $requestObject-> null);
		$tag->insert($pdo);
		$reply->message = "tag posted successfully";
		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);