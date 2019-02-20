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

class Photo {
	use ValidateUuid;
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
	 * @param string $newPhotoUrl string containing actual photo dataTime
	 * @param string|null $newPhotoDateTime date and time photo was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	 public function __construct($newPhotoId, $newPhotoProfileId, $newPhotoTrailId, string $newPhotoUrl, $newPhotoDateTime) {
		 try {
			 $this->setPhotoId($newPhotoId);
			 $this->setphotoProfileId($newPhotoProfileId);
			 $this->setPhotoTrailId($newPhotoTrailId);
			 $this->setPhotoUrl($newPhotoUrl);
			 $this->setPhotoDateTime($newPhotoDateTime);
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
	public function setPhotoTrailId( $newPhotoTrailId) : void {
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
	 * accessor method for photo url
	 *
	 * @return string value of photo url
	 **/

	public function getPhotoUrl() : Uuid{
		return($this->photoUrl);
	}
	/**
	 * mutator method for photo url
	 *
	 * @param string $newPhotoUrl new value of photo url
	 * @throws \RangeException if $newPhotoUrl is not positive
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
	 * accessor method for photo date time
	 *
	 * @return string value of photo date time
	 **/
	public function getPhotoDatetime() : string {
		return($this->photoDateTime);
	}

	/**
	 * mutator method for photo date time
	 *
	 * @param string $newPhotoDateTime new value of photo date time
	 * @throws \InvalidArgumentException if $newPhotoDateTime is not a string or insecure
	 * @throws \RangeException if $newPhotoDateTime is > 140 characters
	 * @throws \TypeError if $newPhotoDateTime is not a string
	 **/
	public function setPhotoDateTime(string $newPhotoDateTime) : void {
		// verify the photo url is secure
		$newPhotoDateTime = trim($newPhotoDateTime);
		$newPhotoDateTime = filter_var($newPhotoDateTime, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPhotoDateTime) === true) {
			throw(new \InvalidArgumentException("photo date time is empty or insecure"));
		}

		// verify the photo date time will fit in the database
		if(strlen($newPhotoDateTime) > 140) {
			throw(new \RangeException("photo date time too large"));
		}

		// store the photo date time
		$this->photoDateTime = $newPhotoDateTime;
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
		$query = "INSERT INTO photo(photoId, photoProfileId, photoTrailId, photoDateTime, photoUrl) VALUES(:photoId, :photoProfileId, :photoTrailId, :photoDateTime, :photoUrl)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = [
			"photoId" => $this->photoId->getBytes(),
			"photoProfileId" => $this->photoProfileId->getBytes(),
			"photoTrailId" => $this->photoTrailId->getBytes(),
			"photoDateTime" => $this->photoDateTime,
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







}
