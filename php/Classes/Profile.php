<?php
namespace CapstoneTrails\AbqTrails;

//our autoloader
require_once("autoload.php");
//composer autoloader
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *
 * This profile is used to input and view data and photos on ABQ Trails web application
 *
 * @author Cassandra Romero <cromero278@cnm.edu>
 *
 */
class Profile {
/**
 * id for user profile, this is a primary key
 * @var Uuid $profileId
 */
	private $profileId;
/**
 * One-time activation token used for profile account creation
 * @var $profileActivationToken
 */
	private $profileActivationToken;
/**
 * url for author avatar (photo)
 * @var $profileAvatarUrl
 */
	private $profileAvatarUrl;
/**
 * profile email address, must be unique
 * @var $profileEmail
 */
	private $profileEmail;
/**
 * profile user's first name
 * @var $profileFirstName
 */
	private $profileFirstName;
/**
 * encrypted profile password
 * @var $profileHash
*/
	private $profileHash;
/**
 * profile user's last name
 * @var $profileLastName
 */
	private $profileLastName;
/**
 * profile username, must be unique
 * @var $profileUsername
 */
	private $profileUsername;

/**
 * constructor for Author
 *
 * @param string|Uuid $newProfileId id for this profile
 * @param string $newProfileActivationToken string containing activation token for account creation
 * @param string $newProfileAvatarUrl string containing url of profile avatar
 * @param string $newProfileEmail unique string containing unique profile email address
 * @param string $newProfileFirstName string containing profile user first name
 * @param string $newProfileHash string containing hashed profile password
 * @param string $newProfileLastName string containing profile user last name
 * @param string $newProfileUsername string containing unique profile username
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 **/
public function __construct($newProfileId, $newProfileActivationToken, $newProfileAvatarUrl, $newProfileEmail, $newProfileFirstName, $newProfileHash, $newProfileLastName, $newProfileUsername) {
	try {
		$this->setProfileId($newProfileId);
		$this->setProfileActivationToken($newProfileActivationToken);
		$this->setProfileAvatarUrl($newProfileAvatarUrl);
		$this->setProfileEmail($newProfileEmail);
		$this->setProfileFirstName($newProfileFirstName);
		$this->setProfileHash($newProfileHash);
		$this->setProfileLastName($newProfileLastName);
		$this->setProfileUsername($newProfileUsername);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}
/**
 * accessor method for profile id
 *
 * @return Uuid of profile Id
 */
	public function getProfileId() : Uuid {
		return ($this->profileId);
	}
/**
 * mutator method for profile id
 *
 * @param Uuid | string $newProfileId
 * @throws \RangeException if $newProfileId is not correct length
 * @throws \TypeError if $newprofileId is not a Uuid or string
 */
	public function setProfileId ($newProfileId) {
		try
			{$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
			$this->profileId = $uuid;
	}
/**
 * accessor method for profile activation token
 * @return string characters in activation token
 *
 */
	public function getProfileActivationToken() : string {
		return ($this->profileActivationToken);
	}
/**
 * mutator method for profile activation token
 *
 * @param string $newProfileActivationToken
 * @throws \RangeException if activation token is not 32 characters
 * @throws \TypeError if activation token is not a string
 */
	public function setProfileActivationToken ($newProfileActivationToken) {
	if(strlen ($newProfileActivationToken) !== 32) {
		throw(new \RangeException("must be 32 characters"));
	}
	$this->profileActivationToken = $newProfileActivationToken;
}
/**
 * accessor method for profile avatar url
 *
 * @return string profile avatar url
 */
	public function getProfileAvatarUrl() : string {
		return ($this->profileAvatarUrl);
	}
/**
 * mutator method for profile avatar url
 *
 * @param string $newProfileAvatarUrl
 * @throws \RangeException if avatar url is greater than 255 characters
 * @throws\InvalidArgumentException if empty
 */
	public function setProfileAvatarUrl ($newProfileAvatarUrl) : void {
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING);
		if(strlen ($newProfileAvatarUrl) > 255) {
			throw(new \RangeException("avatar url is too long"));
		}
		if(empty($newProfileAvatarUrl) === true) {
			throw (new \InvalidArgumentException("profile avatar URL is empty"));
		}
		$this->profileAvatarUrl = $newProfileAvatarUrl;
	}
/**
 * accessor method for profile email
 *
 * @return string profile email address
 */
	public function getProfileEmail() : string {
		return ($this->profileEmail);
	}
/**
 * mutator method for profile email address
 *
 * @param string $newProfileEmail
 * @throws \RangeException if string length is greater than 128 characters
 * @throws \InvalidArgumentException if email is empty
 */

	public function setProfileEmail($newProfileEmail): void {
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail,FILTER_SANITIZE_EMAIL);
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("Email must be less than 128 characters"));
		}
		if(empty($newProfileEmail) === true){
			throw(new \InvalidArgumentException("Email is empty"));
		}
		$this->profileEmail = $newProfileEmail;
	}
/**
 *
 * accessor method for profile first name
 *
 * @return string profile first name
 */
	public function getProfileFirstName() : string {
		return($this->profileFirstName);
	}
/**
 * mutator method for profile first name
 *
 * @param string $newProfileFirstName
 * @throws \RangeException if string length is greater than 32 characters
 * @throws \InvalidArgumentException if first name is empty
 */
	public function setProfileFirstName($newProfileFirstName) : void {
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName,FILTER_SANITIZE_STRING);
		if(strlen($newProfileFirstName) > 32) {
			throw(new \RangeException("First name cannot be more than 32 characters"));
		}
		if(empty($newProfileFirstName) === true) {
			throw (new \InvalidArgumentException("First name required"));
		}
	$this->profileFirstName = $newProfileFirstName;
	}
/**
 * accessor method profileHash
 *
 * @return string profile hash password
 */
	public function getProfileHash () : string {
		return($this->profileHash);
	}
/**
 * mutator method for profile hash
 *
 * @param string $newProfileHash
 * @throws \RangeException if not exactly 97 characters
 * @throws \InvalidArgumentException if empty
 */
	public function setProfileHash($newProfileHash) : void {
		if(strlen($newProfileHash) !== 97){
			throw(new \RangeException("must be 97 characters"));
		}
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("hash is empty"));
		}
		$this->profileHash = $newProfileHash;
	}
/**
 *accessor method for profile last name
 *
 *@return string of profile last name
 */
	public function getProfileLastName() : string {
		return($this->profileLastName);

	}
/**
 * mutator method for profile last name
 * @param string $newProfileLastName
 * @throws \RangeException if string length is greater than 32 characters
 * @throws \InvalidArgumentException if last name is empty
 */
	public function setProfileLastName($newProfileLastName) : void {
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING);
		if(strlen($newProfileLastName) > 32) {
			throw(new \RangeException("Last name cannot be more than 32 characters"));
		}
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("Last name required"));
		}
		$this->profileLastName = $newProfileLastName;
	}

/**
 * accessor method for profile username
 *
 * @return string for profile username
 */
	public function getProfileUsername () : string {
		return($this->profileUsername);
	}
/**
 *mutator method for profile username
 * @param string $newProfileUsername
 * @throws \RangeException if greater than 32 characters
 * @throws \InvalidArgumentException if empty
 */
	public function setProfileUsername ($newProfileUsername) : void {
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING);
		if(strlen($newProfileUsername) > 32){
			throw(new \RangeException("Username must be 32 characters or less"));
		}
		if(empty($newProfileUsername) === true){
			throw(new \InvalidArgumentException("Username required"));
		}
		$this->profileUsername = $newProfileUsername;
	}
	public static function getAllProfiles(\PDO $pdo) : \SplFixedArray {
		$query = "SELECT profileId, profileActivationToken, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername";
		$statement = $pdo->prepare($query);
		$statement->execute();

		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !==false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileUsername"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			}catch(\Exception $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
		}
		return ($profiles);
	}
}

