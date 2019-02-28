<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use CapstoneTrails\AbqTrails\Profile;

/**
 * api for the Profile class
 *
 * @author Scott Wells <swells19@cnm.edu>
 **/

//verify the session, if it is not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mysql connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure id is valid for methods that require it
	if(($method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "PUT") {
		//verify the user has a XSRF token
		verifyXsrf();

		/**
		 * Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input")
		 * to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string.
		 * The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read
		 * from the front end request which is, in this case, a JSON package.
		 **/
		$requestContent = file_get_contents("php://input");

		//this line decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);

		//retrieve the profile to update
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		//enforce the user is signed in and can only update their own profile
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You have to be logged in to edit this profile", 403));
		}

		//update all attributes
		$profile->setProfileAvatarUrl($requestObject->profileAvatarUrl);
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfileFirstName($requestObject->profileFirstName);
		$profile->setProfileLastName($requestObject->profileLastName);
		$profile->setProfileUsername($requestObject->profileUsername);
		$profile->update($pdo);

		//update reply message
		$reply->message = "Profile updated!";
	}

//update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

//encode and return a reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

//	JSON encodes the $reply object and sends it back to the front end.

