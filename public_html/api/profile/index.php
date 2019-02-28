<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use CapstoneTrails\AbqTrails\Profile;

/**
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/trails.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure id is valid for methods that require it
	if(($method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

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

	//perform the actual PUT
	if($method === PUT) {
		//retrieve the profile to update
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		//enforce the user is signed in and can only update their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileEmail()->toString()) {
			throw(new \InvalidArgumentException("You have to be logged in to edit this profile", 403));
		}

		//update all attributes

	}

}
