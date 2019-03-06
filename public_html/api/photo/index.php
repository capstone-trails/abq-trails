<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");

require_once("/etc/apache2/capstone-mysql/Secrets.php");

//include the jwt for Cloudinary
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");

use CapstoneTrails\AbqTrails\{Photo, Profile};

/**
 * Cloudinary API for image upload
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

	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$trailId = filter_input(INPUT_GET, "trailId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$config = readConfig("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config([
		"cloud_name" => $cloudinary->cloudName,
		"api_key" => $cloudinary->apiKey,
		"api_secret" => $cloudinary->apiSecret
	]);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE") && (empty($id) === true)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//process actual GET, POST, DELETE methods
	if($method === "GET") {
		//set XSRF token
		setXsrfCookie();

		//get a photo by id and update reply
		if(empty($id) === false) {
			$photo = Photo::getPhotoByPhotoId($pdo, $id);
		} else if(empty($trailId) === false) {
			$reply->data = Photo::getPhotoByPhotoTrailId($pdo, $trailId)->toArray();
		} else if(empty($profileId) === false) {
			$reply->data = Photo::getPhotoByPhotoProfileId($pdo, $profileId)->toArray();
		}

	} else if($method === "DELETE") {
		//verify that the end user has XSRF token
		verifyXsrf();

		//retrieve the Photo to be deleted
		$photo = Photo::getPhotoByPhotoId($pdo, $id);
		if($photo === null) {
			throw(new \RuntimeException("Photo does not exist", 404));
		}

		//enforce user is signed in and only trying to delete their own photo
		//use the photo id to get trail id to get profile id; compare it to the session profile id
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== Trail::getTrailByTrailId($pdo, $photo->getPhotoTrailId())->getPhotoProfileId()) {
			throw(new \InvalidArgumentException("Only the user can delete this image", 403));
		}

		//enforce the user has a JWT token
		validateJwtHeader();

		//delete image from Cloudinary
		$cloudinaryResult = \Cloudinary\Uploader::destroy($photo->getPhotoCloudinaryToken());

		//delete photo database
		$photo->delete($pdo);

		//update reply
		$reply->message = "Photo deleted";

	} else if($method === "POST") {
		//verify that the end user has XSRF token
		verifyXsrf();

		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to upload images", 401));
		}

		//assigning variable to the user profile, add image extension
		$tempUserFileName = $_FILES["image"]["tmp_name"];

		//upload image to Cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));

		//after sending the image to Cloudinary, get the image
		$profile = Profile::getProfileByProfileId($pdo, $_SESSION["profile"]->getProfileId());
		if($profile === null) {
			throw(new RuntimeException("Profile not found", 404));
		}

		//set image upload to Cloudinary
		$profile->setProfileImage($cloudinaryResult["secure_url"]);
		$profile->update($pdo);
		$reply->message = "Image uploaded successfully!";
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
echo json_encode($reply);