<?php
namespace CapstoneTrails\AbqTrails;

//our autoloader
require_once("autoload.php");
//composer autoloader
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This trait will inject a method to validate mySQL style attributes in photo.
 * convert a string representation to a photo object or throw an exception.
 *
 * @author Ronald Luna rluna41@cnm.edu
 **/

class Photo implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this photo; this is the primary key
	 * @var Uuid $photoId
	 **/
	private $photoId;
	/**
	 * id of the PhotoId that sent this photo; this is a primary key
	 * @var Uuid $photoProfileUserId
	 **/
	private $photoProfileId;
	/**
	 * id of photoProfileTrailId that sent this photo; this is a primary key
	 * @Var \photoProfileTrailId $photoProfileTrailId
	 **/
	private $photoTrailId;
	/**
	 * photo Cloudinary token for uploading pictures to Cloudinary photo api
	 * @var string $photoCloudinaryToken
	 **/
	private $photoCloudinaryToken;
	/**
	 * photo date and time this photo was sent, in a PHP photoDateTime object
	 * @var \DateTime $photoDatetime
	 **/
	private $photoDateTime;
	/**
	 * actual textual content of this photo
	 * @var string $photoUrl
	 **/
	private $photoUrl;
	/**
	 * constructor for this photo
	 *
	 * @param string|Uuid $newPhotoId id of this photo or null if a new photo
	 * @param string|Uuid $newPhotoProfileId id of the photo trail Id that sent this photo
	 * @param string|Uuid $newPhotoTrailId id of the photo Trail Id
	 * @param string $newPhotoCloudinaryToken activation token for photo upload to Cloudinary api
	 * @param \DateTime|string|null $newPhotoDateTime date and time photo was sent or null if set to current date and time
	 * @param string $newPhotoUrl string containing http link to photo
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	 public function __construct($newPhotoId, $newPhotoProfileId, $newPhotoTrailId, string $newPhotoCloudinaryToken, $newPhotoDateTime = null, string $newPhotoUrl) {
		 try {
			 $this->setPhotoId($newPhotoId);
			 $this->setPhotoProfileId($newPhotoProfileId);
			 $this->setPhotoTrailId($newPhotoTrailId);
			 $this->setPhotoCloudinaryToken($newPhotoCloudinaryToken);
			 $this->setPhotoDateTime($newPhotoDateTime);
			 $this->setPhotoUrl($newPhotoUrl);
		 } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			 $exceptionType = get_class($exception);
			 throw(new $exceptionType($exception->getMessage(), 0, $exception));
		 }
	 }
	/**
	 * accessor method for photo id
	 *
	 * @return Uuid value of photo id
	 **/
	public function getPhotoId() : Uuid {
		return($this->photoId);
	}

	/**
	 * mutator method for photo id
	 *
	 * @param Uuid|string $newPhotoId new value of photo id
	 * @throws \RangeException if $newPhotoId is not positive
	 * @throws \TypeError if $newPhotoId is not a uuid or string
	 **/
	public function setPhotoId($newPhotoId) : void {
		try {
			$uuid = self::validateUuid($newPhotoId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the photo id
		$this->photoId = $uuid;
	}

	/**
	 * accessor method for photo profile user id
	 *
	 * @return Uuid value of photo profile user id
	 **/
	public function getPhotoProfileId() : Uuid{
		return($this->photoProfileId);
	}

	/**
	 * mutator method for photo profile user id
	 *
	 * @param string | Uuid $newPhotoProfileId new value of photo profile user id
	 * @throws \RangeException if $newProfileUserId is not positive
	 * @throws \TypeError if $newPhotoProfileUserId is not an integer
	 **/
	public function setPhotoProfileId( $newPhotoProfileId) : void {
		try {
			$uuid = self::validateUuid($newPhotoProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile user id
		$this->photoProfileId = $uuid;
	}
	/**
	 * accessor method for photo trail id
	 *
	 * @return Uuid value of photo profile user id
	 **/
	public function getPhotoTrailId() : Uuid{
		return($this->photoTrailId);
	}

	/**
	 * mutator method for photo trail id
	 *
	 * @param string | Uuid $newPhotoTrailId new value of photo profile user id
	 * @throws \RangeException if $newProfileUserId is not positive
	 * @throws \TypeError if $newPhotoProfileUserId is not an integer
	 **/
	public function setPhotoTrailId($newPhotoTrailId) : void {
		try {
			$uuid = self::validateUuid($newPhotoTrailId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile user id
		$this->photoTrailId = $uuid;
	}

	/**
	 * accessor method for photo cloudinary token
	 *
	 * @return string value of photo cloudinary token
	 **/
	public function getPhotoCloudinaryToken() : string {
		return($this->photoCloudinaryToken);
	}

	/**
	 * mutator method for photo cloudinary token
	 * @param string $newPhotoCloudinaryToken new value of photo cloudinary token
	 * @throws \InvalidArgumentException if $newPhotoCloudinaryToken uses invalid characters or is too big
	 * @throws \TypeError if $newPhotoCloudinaryToken is not a string
	 **/
	public function setPhotoCloudinaryToken(string $newPhotoCloudinaryToken) : void {
		$newPhotoCloudinaryToken = filter_var($newPhotoCloudinaryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPhotoCloudinaryToken) === true) {
			throw(new \InvalidArgumentException("photo cloudinary token is empty or insecure"));
		}

		// store the image cloudinary token
		$this->photoCloudinaryToken = $newPhotoCloudinaryToken;
	}

	/**
	 * accessor method for photo date time

	 * @return  \DateTime value of photo date time
	 **/
	public function getPhotoDatetime() : \DateTime {
		return($this->photoDateTime);
	}

	/**
	 * mutator method for photo date time
	 *
	 * @param \DateTime $newPhotoDateTime new value of photo date time
	 * @throws \InvalidArgumentException if $newPhotoDateTime is not a string or insecure
	 * @throws \RangeException if $newPhotoDateTime if the date time does not exist
	 * @throws \TypeError if $newPhotoDateTime is not a string
	 * @throws \Exception if $newPhotoDateTime throws a generic exception
	 **/
	public function setPhotoDateTime($newPhotoDateTime = null) : void {
		// base case: if the date is null, use the current date and time
		if($newPhotoDateTime === null) {
			$this->photoDateTime = new \DateTime();
			return;
		}
		//store the profile date using the validate date trait
		try {
			$newPhotoDateTime= self::validateDateTime($newPhotoDateTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the photo date time
		$this->photoDateTime = $newPhotoDateTime;
	}

	/**
	 * accessor method for photo url
	 *
	 * @return string value of photo url
	 **/

	public function getPhotoUrl() : string {
		return($this->photoUrl);
	}
	/**
	 * mutator method for photo url
	 *
	 * @param string $newPhotoUrl new value of photo url
	 * @throws \InvalidArgumentException if $newPhotoUrl is not positive
	 * @throws \TypeError if $newPhotoUrl is not an integer
	 **/
	public function setPhotoUrl($newPhotoUrl) : void {
		$newPhotoUrl = trim($newPhotoUrl);
		$newPhotoUrl = filter_var($newPhotoUrl, FILTER_VALIDATE_URL);

		if(strlen($newPhotoUrl) > 255){
			throw(new \RangeException("Url too long"));
		}
		if(empty($newPhotoUrl) === true){
			throw(new \InvalidArgumentException("Url is empty"));
		}
		$this->photoUrl = $newPhotoUrl;
	}

	/**
	 * inserts Photo into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO photo(photoId, photoProfileId, photoTrailId, photoCloudinaryToken, photoDateTime, photoUrl) VALUES(:photoId, :photoProfileId, :photoTrailId, :photoCloudinaryToken :photoDateTime, :photoUrl)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->photoDateTime->format("Y-m-d H:i:s.u");
		$parameters = [
			"photoId" => $this->photoId->getBytes(),
			"photoProfileId" => $this->photoProfileId->getBytes(),
			"photoTrailId" => $this->photoTrailId->getBytes(),
			"photoCloudinaryToken" => this->$this->photoCloudinaryToken,
			"photoDateTime" => $formattedDate,
			"photoUrl" => $this->photoUrl
		];
		$statement->execute($parameters);
	}

	/**
	 * deletes Photo from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM photo WHERE photoId = :photoId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["photoId" => $this->photoId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates Photo in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE photo SET photoProfileId = :photoProfileId, photoTrailId = :photoTrailId, photoDateTime = :photoDateTime, photoUrl = :photoUrl WHERE photoId = :photoId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->photoDateTime->format("Y-m-d H:i:s.u");
		//bind the member variables to the place holders in the template
		$parameters = [
			"photoId" => $this->photoId->getBytes(),
			"photoProfileId" => $this->photoProfileId->getBytes(),
			"photoTrailId" => $this->photoTrailId->getBytes(),
			"photoDateTime" => $formattedDate,
			"photoUrl" => $this->photoUrl
		];
		$statement->execute($parameters);
	}

	/** gets the Photo by photo id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $photoId
	 * @return photo if found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public static function getPhotoByPhotoId(\PDO $pdo, $photoId): ?Photo {
		//sanitize photoId before search
		try {
			$photoId = self::validateUuid($photoId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT photoId, photoProfileId, photoTrailId, photoDateTime, photoUrl FROM photo WHERE photoId = :photoId";
		$statement = $pdo->prepare($query);

		//bind the photo id to the placeholder
		$parameters = ["photoId" => $photoId->getBytes()];
		$statement->execute($parameters);

		//grab photo from mySQL
		try {
			$photo = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$photo = new Photo($row["photoId"], $row["photoProfileId"], $row["photoTrailId"], $row["photoDateTime"], $row["photoUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($photo);
	}

	/** gets the Photo by profile id
	*
	* @param \PDO $pdo PDO connection object
	* @param Uuid|string $photoProfileId
	* @return \SplFixedArray SplFixedArray of photos found
	* @throws \PDOException when mySQL related errors occur
	* @throws \TypeError when variables are not correct data type
	**/
	public static function getPhotoByPhotoProfileId(\PDO $pdo, $photoProfileId) : \SplFixedArray {
		// sanitize the photoProfileId before searching
		try {
			$photoProfileId = self::validateUuid($photoProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT photoId, photoProfileId, photoTrailId, photoDateTime, photoUrl FROM photo WHERE photoProfileId = :photoProfileId";
		$statement = $pdo->prepare($query);

		// bind the photo id to the place holder in the template
		$parameters = ["photoProfileId" => $photoProfileId->getBytes()];
		$statement->execute($parameters);

		// build an array of Photos
		$photos = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$photo = new Photo($row["photoId"], $row["photoProfileId"], $row["photoTrailId"], $row["photoDateTime"], $row["photoUrl"]);
				$photos[$photos->key()] = $photo;
				$photos->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($photos);
	}
	/**
	 * gets the  Photo by PhotoTrailId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $photoTrailId trial id to search for
	 * @return \SplFixedArray SplFixedArray of photos found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getPhotoByPhotoTrailId(\PDO $pdo, $photoTrailId) : \SplFixedArray {
		// sanitize the photoTrialId before searching
		try {
			$photoTrailId = self::validateUuid($photoTrailId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT photoId, photoProfileId, photoTrailId, photoDateTime, photoUrl FROM photo WHERE photoTrailId = :photoTrailId";
		$statement = $pdo->prepare($query);

		// bind the photo id to the place holder in the template
		$parameters = ["photoTrailId" => $photoTrailId->getBytes()];
		$statement->execute($parameters);

		// build an array of Photos
		$photos = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$photo = new Photo($row["photoId"], $row["photoProfileId"], $row["photoTrailId"], $row["photoDateTime"], $row["photoUrl"]);
				$photos[$photos->key()] = $photo;
				$photos->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($photos);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		$fields["photoId"] = $this->photoId->toString();
		//format the date so the front end can consume it
		$fields["photoDateTime"] = round(floatval($this->photoDateTime->format("U.u")) * 1000);
		return($fields);

	}
}
