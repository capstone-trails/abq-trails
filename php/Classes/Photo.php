<?php
namespace  abq-trails;
/**
 * This trait will inject a method to validate mySQL style attributes in photo.
 * convert a string representation to a photo object or throw an exception.
 *
 * @author Ronald Luna rluna41@cnm.edu
 **/

class Photo() {
	/**
	 * id for this photo; this is the primary key
	 * @var Uuid $photoId
	 **/
	private $photoId;
	/**
	 * id of the PhotoId that sent this photo; this is a primary key
	 * @var Uuid $photoProfileUserId
	 **/
	private $photoProfileUserId;
	/**
	 * actual textual content of this photo
	 * @var string $photoUrl
	 **/
	private $photoUrl;
	/**
	 * photo date and time this photo was sent, in a PHP photoDateTime object
	 * @var \photoDateTime $photoDatetime
	 **/
	private $photoDateTime;
	/**
	 * id of photoProfileTrailId that sent this photo; this is a primary key
	 * @Var \photoProfileTrailId $photoProfileTrailId
	 **/
	private $photoProfileTrailId;
	/**
	 * constructor for this photo
	 *
	 * @param string|Uuid $newPhotoId id of this photo or null if a new photo
	 * @param string|Uuid $newPhotoProfileUserId id of the ProfileUserId that sent this photo
	 * @param string $newPhotoUrl string containing actual photo dataTime
	 * @param \photoDateTime|string|null $newPhotoDateTime date and time photo was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	 public function __construct($newPhototId, $newPhotoProfileUserId, string $newPhotoUrl, $newPhotoDateTime = null){
	 try {
		$this->setPhotoId($newPhotoId);
		$this->setphotoProfileUserId($newPhotoProfileUserId);
		$this->setPhotoUrl($newPhotoUrl);
		$this->setPhotoDateTime($newPhotoDateTime);
	}
	//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}
	public function __construct($newPhotoId, $newPhotoProfileUserId, string $newPhotoUrl, $newPhotoDateTime = null) {
	try {
		$this->setPhotoId($newPhotoId);
		$this->setPhotoProfileUserId($newPhotoProfileUserId);
		$this->setPhotoUrl($newPhotoUrl);
		$this->setPhotoDateTime($newPhotoDateTime);
	}
		//determine what exception type was thrown
	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
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
	public function setPhotoId( $newPhotoId) : void {
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
	public function getPhotoProfileUserId() : Uuid{
		return($this->photoProfileUserId);
	}

	/**
	 * mutator method for photo profile user id
	 *
	 * @param string | Uuid $newPhotoProfileUserId new value of photo profile user id
	 * @throws \RangeException if $newProfileUserId is not positive
	 * @throws \TypeError if $newPhotoProfileUserId is not an integer
	 **/
	public function setPhotoProfileUserId( $newPhotoProfileUserId) : void {
		try {
			$uuid = self::validateUuid($newPhotoProfileUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile user id
		$this->photoProfileUserId = $uuid;
	}
	/**
	 * accessor method for photo url
	 *
	 * @return Uuid value of photo url
	 **/
	public function getPhotoUrl() : Uuid{
		return($this->photoUrl);
	}

	/**
	 * mutator method for photo url
	 *
	 * @param string | Uuid $newPhotoUrl new value of photo url
	 * @throws \RangeException if $newPhotoUrl is not positive
	 * @throws \TypeError if $newPhotoUrl is not an integer
	 **/
	public function setPhotoUrl( $newPhotoUrl) : void {
		try {
			$uuid = self::validateUuid($newPhotoUrl);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the photo url
		$this->photoUrl = $uuid;
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
	 * @throws \TypeError if $newPhotodatetime is not a string
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
	 * deletes this photo from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM photo WHERE photoId = :photoId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["photoId" => $this->photoId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this photo in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE photo SET photoProfileUserId = :photoProfileUserId, photoUrl = :photoUrl, photoDatetime = :photoDateTIme WHERE photoId = :photoId";
		$statement = $pdo->prepare($query);


		$formattedDateTime = $this->photoDate->format("Y-m-d H:i:s.u");
		$parameters = ["photoId" => $this->photoId->getBytes(),"photoProfileUserId" => $this->photoProfileUserId->getBytes(), "photoUrl" => $this->photoUrl, "photoDateTime" => $formattedDateTime];
		$statement->execute($parameters);
	}

	/**
	 * gets the photo by photoId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $photoId photo id to search for
	 * @return photo|null photo found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getPhotoByPhotoId(\PDO $pdo, $photoId) : ?Photo {
		// sanitize the photoId before searching
		try {
			$photoId = self::validateUuid($photoId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT photoId, photoProfileUserId, photoUrl, photoDateTime FROM photo WHERE photoId = :photoId";
		$statement = $pdo->prepare($query);

		// bind the photo id to the place holder in the template
		$parameters = ["photoId" => $photoId->getBytes()];
		$statement->execute($parameters);

		// grab the photo from mySQL
		try {
			$photo = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$photo = new photo($row["photoId"], $row["photoProfileUserId"], $row["photoUrl"], $row["photoDateTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($photo);
	}

	/**
	 * gets the photo by profile user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $photoProfileUserId profile user id to search by
	 * @return \SplFixedArray SplFixedArray of photos found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPhotoByPhotoProfileUserId(\PDO $pdo, $photoProfileUserId) : \SplFixedArray {

		try {
			$photoProfileUserId = self::validateUuid($photoProfileUSerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT photoId, photoProfileUserId, photoUrl, photoDateTIme FROM photo WHERE photoProfileUSerId = :photoProfileUserId";
		$statement = $pdo->prepare($query);
		// bind the photo profile user id to the place holder in the template
		$parameters = ["photoProfileUserId" => $photoProfileUserId->getBytes()];
		$statement->execute($parameters);
		// build an array of photos
		$photos = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$photo = new photo($row["photoId"], $row["photoProfileUserId"], $row["photoUrl"], $row["photoDateTime"]);
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
	 * gets the photo by url
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $photoUrl photo url to search for
	 * @return \SplFixedArray SplFixedArray of photos found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getphotoByPhotoUrl(\PDO $pdo, string $photoUrl) : \SplFixedArray {
		// sanitize the description before searching
		$photoUrl = trim($photoUrl);
		$photoUrl = filter_var($photoUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($photoUrl) === true) {
			throw(new \PDOException("photo url is invalid"));
		}

		// escape any mySQL wild cards
		$photoUrl = str_replace("_", "\\_", str_replace("%", "\\%", $photoUrl));

		// create query template
		$query = "SELECT photoId, photoProfileUserId, photoUrl, photoDateTime FROM photo WHERE photoUrl LIKE :photoUrl";
		$statement = $pdo->prepare($query);

		// bind the photo url to the place holder in the template
		$photoUrl = "%$photoUrl%";
		$parameters = ["photoUrl" => $photoUrl];
		$statement->execute($parameters);

		// build an array of photos
		$photos = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$photo = new photo($row["photoId"], $row["photoProfileUserId"], $row["photoUrl"], $row["photoDateTime"]);
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
	 * gets all photos
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of photos found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllPhotos(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT photoId, photoProfileUserId, photoUrl, photoDateTIme FROM photo";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of photos
		$photos = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$photo = new photo($row["photoId"], $row["photoProfileUserId"], $row["photoUrl"], $row["photoDateTime"]);
				$photos[$photos->key()] = $photo;
				$photos->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($photos);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["photoId"] = $this->photoId->toString();
		$fields["photoProfileUserId"] = $this->photoProfileUserId->toString();

		//format the date time so that the front end can consume it
		$fields["photoDateTime"] = round(floatval($this->photoDateTime->format("U.u")) * 1000);
		return($fields);
	}
