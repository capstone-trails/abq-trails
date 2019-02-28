<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");


use CapstoneTrails\AbqTrails\Profile;

/**
 * api to check profile activation status
 *
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.00
 **/

//check the session, if it is not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mysql connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize and store activation token

	$id = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	var_dump($id);
	//make sure the activation token is the correct size
	if(strlen($id) !== 32) {
		throw(new \InvalidArgumentException("activation token is not correct length", 405));
	}

	//verify that the activation token is a string value of a hexadecimal
	if(ctype_xdigit($id) === false) {
		throw(new \InvalidArgumentException("activation token is empty or invalid", 405));
	}

	//handle the "GET" HTTP request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//find profile associated with the activation token
		$profile = Profile::getProfileByProfileActivationToken($pdo, $id);

		//verify the profile is not null
		if($profile !== null) {
			//make sure the activation token matches
			if($id === $profile->getProfileActivationToken()) {
				//set activation token to null
				$profile->setProfileActivationToken(null);

				//update the profile in the database
				$profile->update($pdo);

				//set the reply for the end user
				$reply->data = "Your profile is activated";
			}
		} else {
			//throw an exception if the activation token does not exist
			throw(new \InvalidArgumentException("Profile with this activation token does not exist", 404));
		}
	} else {
		//throw an exception if the HTTP request is not a GET
		throw(new \InvalidArgumentException("Invalid HTTP method request", 403));
	}

//update the reply object status and message state variables if an exception or type exception was thrown
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}


//prepare and the send the reply
//header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);

