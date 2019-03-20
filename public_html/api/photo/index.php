<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");


use CapstoneTrails\AbqTrails\{Photo, Profile, Trail};


/**
 * Cloudinary API for image upload
 *
 * DEAR FUTURE CODERS: NOTHING WORKS, MAYBE YOU SHOULD GO OFF A DIFFERENT EXAMPLE :-)
 *
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.03 updated from Brent Kie & Marty Bonacci
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mysql connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$pdo = $secrets->getPdoObject();
	$cloudinary = $secrets->getSecret("cloudinary");

	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$trailId = filter_input(INPUT_GET, "trailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	//process GET requests
	if($method === "GET") {
		setXsrfCookie();
		if(empty($trailId) === false) {
			$reply->data = Photo::getPhotoByPhotoTrailId($pdo, $trailId);
		}
	} else if($method === "POST") {
		var_dump($_FILES);
		verifyXsrf();
		$photoTrailId = filter_input(INPUT_POST, "trailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$photoUrl = filter_input(INPUT_POST, "photoUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$tempUserFileName = $_FILES["photo"]["tmp_name"];
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 200, "crop" => "scale"));
		$photo = new Photo(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $photoTrailId, $cloudinaryResult["signature"], new \DateTime(), $cloudinaryResult["secure_url"]);
		$photo->insert($pdo);
		var_dump($photo);
		$reply->message = "Image uploaded!";
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
echo json_encode($reply);