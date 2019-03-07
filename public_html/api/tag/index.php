<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use CapstoneTrails\AbqTrails\Tag;
;
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
	//grab the mysql connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize the search parameters
	$id = $tagId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
	$tagName = filter_input(INPUT_GET, "tagName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific trail based on arguments provided and update reply
		if(empty($id) === false) {
			$reply->data = Tag::getTagByTagId($pdo, $id);
		} else if(empty($tagName) === false) {
			$reply->data = Tag::getTagByTagName($pdo, $tagName)->toArray();
		} else {
			$reply->data = Tag::getAllTags($pdo)->toArray();
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


		if(empty($requestObject->tagName) === true) {
			throw (new \InvalidArgumentException("Tag needs a name", 405));
		}

		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $requestObject->tagName);
		$tag->insert($pdo);
		$reply->message = "tag added";
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