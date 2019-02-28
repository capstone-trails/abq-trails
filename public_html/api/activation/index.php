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
	//(??MAYBE USE THIS?? make sure "id" is changed to "activation" on line 5 of .htaccess. The Data Design example has no .htaccess for activation.)
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the activation token is the correct size
	if(strlen($activation) !== 32) {
		throw(new \InvalidArgumentException("activation token is not correct length", 405));
	}

	//verify that the activation token is a string value of a hexadecimal
	if(ctype_xdigit($activation) === false) {
		throw(new \InvalidArgumentException("activation token is empty or invalid", 405));
	}

	//handle the "GET" HTTP request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//find profile associated with the activation token
		$profile = Profile::getProfileByProfileActivationToken($pdo, $activation);

		//verify the profile is not null
		if($profile !== null) {
			//make sure the activation token matches
			if($activation === $profile->getProfileActivationToken()) {
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

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

		<!-- JSON encode the $reply object and console.log it -->
		<script>console.log(<?php echo json_encode($reply);?>);</script>

		<title>ABQ Trails | Activate Account</title>
	</head>

	<!-- STYLE THIS FOR APP	-->
	<body>
		<div class="container">
			<div class="jumbotron my-5">
				<h1>ABQ Trails | Activate Account</h1>
				<hr>
				<p class="lead d-flex">

					<!-- echo the $reply message to the front end -->
					<?php
					//            echo $reply->message . "&nbsp;";
					if($reply->status === 200) {
						echo "<span class=\"align-self-center badge badge-success\">Success! Use this code to sign in to your profile!</span>";
					} else {
						echo "<span class=\"align-self-center badge badge-danger\">Code:&nbsp;" . $reply->status . "</span>";
					}
					?>

				</p>
				<div class="mt-4">
					<a class="btn btn-lg" href="https://bootcamp-coders.cnm.edu/~mschmitt5/abq-street-art/public_html/"><i class="fa fa-sign-in"></i>&nbsp;Sign In</a>
				</div>
			</div>
		</div>
	</body>
</html>

