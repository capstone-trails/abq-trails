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
class Profile implements \JsonSerializable {
	//use Validate Uuid
	use ValidateUuid;
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
public function __construct($newProfileId, ?string $newProfileActivationToken, ?string $newProfileAvatarUrl, $newProfileEmail, $newProfileFirstName, $newProfileHash, $newProfileLastName, $newProfileUsername) {
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
 * @throws \TypeError if $newProfileId is not a Uuid or string
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
	public function getProfileActivationToken() : ?string {
		return ($this->profileActivationToken);
	}
/**
 * mutator method for profile activation token
 *
 * @param string $newProfileActivationToken
 * @throws \RangeException if activation token is not 32 characters
 * @throws \TypeError if activation token is not a string
 */
	public function setProfileActivationToken (?string $newProfileActivationToken) {
/**		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}
 */
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
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
	public function setProfileAvatarUrl (?string $newProfileAvatarUrl) : void {
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_URL);
		if($newProfileAvatarUrl === null) {
			$this->profileAvatarUrl = null;
		}
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
	/**
	 * inserts Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert (\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername) VALUES(:profileId, :profileActivationToken, :profileAvatarUrl, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profileUsername)";
		$statement = $pdo->prepare($query);
		//bind variables to place holders in the template
		$parameters =
			["profileId" => $this->profileId->getBytes(),
			"profileActivationToken" => $this->profileActivationToken,
			"profileAvatarUrl" => $this->profileAvatarUrl,
			"profileEmail" => $this->profileEmail,
			"profileFirstName" => $this->profileFirstName,
			"profileHash" => $this->profileHash,
			"profileLastName" => $this->profileLastName,
			"profileUsername" => $this->profileUsername];
		$statement->execute($parameters);

	}
	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind variables to place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAvatarUrl = :profileAvatarUrl, profileEmail = :profileEmail, profileFirstName = :profileFirstName, profileHash = :profileHash, profileLastName = :profileLastName, profileUsername = :profileUsername WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind variables to place holders in the template
		$parameters = ["profileActivationToken" =>$this->profileActivationToken, "profileAvatarUrl" => $this->profileAvatarUrl, "profileEmail" => $this->profileEmail,
			"profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profileUsername" => $this->profileUsername, "profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}
	//todo optional delete getprofilebyprofileusername
	/**
	 * gets Profile by profile id
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $profileId to search by
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related issues occur
	 * @throws \TypeError when variables are not the correct type of data
	 */
	public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?Profile {
		// sanitize the profileId before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template

		$query = "SELECT profileId, profileActivationToken, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind variables to place holders in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		//grab profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileUsername"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}
	/**
	 * get the Profile by profile activation token
	 * @param string $profileActivationToken
	 * @param \PDO $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) {
		//make sure activation token is in the right format and that it is a string of a hexadecimal
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		//create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile activation token to the placeholders
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileUsername"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}
	/**
	 * gets the Profile by profile email
	 * @param \PDO $pdo PDO connection object
	 * @param String $profileEmail profile email to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, $profileEmail) : ?Profile {
		//sanitize profile id before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		//create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		//bind profile email to placeholders
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);
		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileUsername"]);
				}
			} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
		}
	/**
	 * gets the Profile by profile username
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUsername profile username to search for
	 * @return \SplFixedArray of Profiles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileUsername(\PDO $pdo, string $profileUsername) : \SplFixedArray {
		// sanitize the description before searching
		$profileUsername = trim($profileUsername);
		$profileUsername = filter_var($profileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUsername) === true) {
			throw(new \PDOException("profile username is invalid"));
		}
		// escape any mySQL wild cards
		$profileUsername = str_replace("_", "\\_", str_replace("%", "\\%", $profileUsername));
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileUsername LIKE :profileUsername ";
		$statement = $pdo->prepare($query);
		// bind the profile content to the place holder in the template
		$profileUsername = "%$profileUsername%";
		$parameters = ["profileUsername" => $profileUsername];
		$statement->execute($parameters);
		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try{
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileUsername"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		unset($fields['profileHash']);
		return ($fields);
	}
}

