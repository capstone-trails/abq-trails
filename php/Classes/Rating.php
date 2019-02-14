<?php
namespace CapstoneTrails\AbqTrails;

//our autoloader
require_once("autoload.php");
//composer autoloader
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class rating
 * @package abqtrails
 *
 * @author Robert Dominguez <rdominguez45@cnm.edu
 **/
class rating {
	use ValidateUuid;
	/**
	 * id of the profile that rated the trail; this is a foreign key
	 * @var Uuid $ratingProfileId
	 **/
	private $ratingProfileId;
	/**
	 * id of the trail being rated; this is a foreign key
	 * @var Uuid $ratingTrailId
	 **/
	private $ratingTrailId;
	/**
	 * what the difficultly of the trail is
	 * @var $ratingDifficulty
	 **/
	private $ratingDifficulty;
	/**
	 * what might be on the trail
	 * @var $ratingValue
	 **/
	private $ratingValue;


	/**
	 * constructor for this Rating
	 *
	 * @param string|Uuid $newRatingProfileId id of the profile that's making the rating
	 * @param string|Uuid $newRatingTrailId id of the trail that's being rated
	 * @param string $newRatingDifficulty string that tells how difficult the trail is
	 * @param string $newRatingValue string that tells what might be on the trails.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if some other exception occurs
	 * @Documention https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newRatingProfileId, $newRatingTrailId, string $newRatingDifficulty, string $newRatingValue) {
		try {
			$this->setRatingProfileId($newRatingProfileId);
			$this->setRatingTrailId($newRatingTrailId);
			$this->setRatingDifficulty($newRatingDifficulty);
			$this->setRatingValue($newRatingValue);
		} // determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for ratingProfileId
	 *
	 * @return Uuid value of rating profile id
	 **/
	public function getRatingProfileId(): Uuid {
		return ($this->ratingProfileId);
	}
	/**
	 * mutator method for rating profile id
	 *
	 * @param string|Uuid $newRatingProfileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newRatingProfileId is not an integer
	 **/
	public function setRatingProfileId($newRatingProfileId): void {
		try {
			$uuid = self::validateUuid($newRatingProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the profile id
		$this->ratingProfileId = $uuid;
	}


	/**
	 * accessor method for ratingTrailId
	 *
	 * @return Uuid value of rating trail id
	 **/
	public function getRatingTrailId(): Uuid {
		return ($this->ratingTrailId);
	}
	/**
	 * mutator method for rating trail id
	 *
	 * @param string|Uuid $newRatingTrailId
	 * @throws \RangeException if $newTrailId is not positive
	 * @throws \TypeError if $newRatingTrailId is not an integer
	 **/
	public function setRatingTrailId($newRatingTrailId): void {
		try {
			$uuid = self::validateUuid($newRatingTrailId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the profile id
		$this->ratingTrailId = $uuid;
	}


	/**
	 * accessor method for rating difficulty
	 *
	 * @return string value of rating difficulty
	 **/
	public function getRatingDifficulty(): string {
		return ($this->ratingDifficulty);
	}
	/**
	 * mutator method for rating difficulty
	 *
	 * @param string $newRatingDifficulty
	 * @throws \InvalidArgumentException if $newRatingDifficulty
	 * @throws \RangeException if $newRatingDifficulty
	 * @throws \TypeError if $newRatingDifficulty is not a string
	 **/
	//todo treat difficulty like an integer
	public function setRatingDifficulty(string $newRatingDifficulty): void {
		// verify the rating difficulty is secure
		$newRatingDifficulty = trim($newRatingDifficulty);
		$newRatingDifficulty = filter_var($newRatingDifficulty, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRatingDifficulty) === true) {
			throw (new \InvalidArgumentException("rating difficulty is empty or insecure"));
		}
		// verify the rating content will fit in the database
		if(strlen($newRatingDifficulty) > 16) {
			throw (new \RangeException("rating difficulty is too large"));
		}
		// store the rating difficulty
		$this->ratingDifficulty = $newRatingDifficulty;
	}


	/**
	 * accessor method for rating value
	 *
	 * @return string value of rating value
	 **/
	public function getRatingValue(): string {
		return ($this->ratingValue);
	}
	/**
	 * mutator method for rating value
	 *
	 * @param string $newRatingValue
	 * @throws \InvalidArgumentException if $newRatingValue
	 * @throws \RangeException if $newRatingValue
	 * @throws \TypeError if $newRatingValue is not a string
	 **/
	//todo treat value like an integer
	public function setRatingValue(string $newRatingValue) : void {
		// verify the rating value is secure
		$newRatingValue = trim($newRatingValue);
		$newRatingValue = filter_var($newRatingValue, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRatingValue) === true){
			throw (new \InvalidArgumentException("rating value is empty or insecure"));
		}
		// verify the rating value will fit in the database
		if (strlen($newRatingValue) > 5) {
			throw (new \RangeException("rating value is too large"));
		}
		// store the rating value
		$this->ratingDifficulty = $newRatingValue;
	}


	//todo add insert update delete getRatingByRatingProfileIdAndRatingTrailId
	/**
	 * inserts this Rating into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO rating(ratingProfileId, ratingTrailId, ratingValue, ratingDifficulty) VALUES (:ratingProfileId, :ratingTrailId, ratingValue, ratingDifficulty)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["ratingProfileId" => $this->ratingProfileId->getBytes(), "ratingTrailId" => $this->ratingTrailId->getBytes(), "ratingValue" => $this->ratingValue, "ratingDifficulty" => $this->ratingDifficulty];
		$statement->execute($parameters);
	}


	/**
	 * deletes this Rating from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM rating WHERE ratingProfileId AND ratingTrailId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the placeholder in the template
		$parameters = ["ratingProfileId"=> $this->ratingProfileId, "rating"];
		$statement->execute($parameters);

	}


	/**
	 * updates this Rating in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE rating SET ratingProfieId = :ratingProfileId, ratingTrailId = :ratingTrailId, ratingValue = :ratingValue, ratingDifficulty = :ratingDifficulty";
		$statement = $pdo->prepare($query);
		$parameters = ["ratingProfileId" => $this->ratingProfileId->getBytes(),"ratingTrailId" => $this->ratingTrailId->getBytes(), "ratingValue" => $this->ratingValue, "ratingDifficulty => $this->ratingDifficulty"];
		$statement->execute($parameters);
	}


	/**
	 * gets the Rating by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $ratingProfileId
	 * @return \SplFixedArray SplFixedArray of Ratings found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public function getRatingByRatingProfileIdAndRatingTrailId(\PDO $pdo, $ratingProfileId) : \SplFixedArray{
		try {
			$ratingProfileId = self::validateUuid($ratingProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT ratingProfileId, ratingTrailId, ratingValue, ratingDifficulty FROM rating WHERE ratingProfileId = :ratingProfileId AND ratingTrailId = :ratingTrailId";
		$statement = $pdo->prepare($query);
		// bind the rating profile id to the place holder in the template
		$parameters = ["ratingProfileId" => $ratingProfileId, "ratingTrailId" => $ratingTrailId];
		$statement->execute($parameters);
		// build an array of ratings
		$ratings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false){
			try {
				$rating = new Rating($row["ratingProfileId"], $row["ratingTrailId"],$row["ratingValue"],$row["ratingDifficulty"]);
				$ratings[$ratings->key()] = $rating;
				$ratings->next();
			} catch(\Exception $exception){
				// if the row couldn't be converted, rethrow it
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($ratings);
	}


	/**
	 * gets the Rating by trail id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $ratingTrailId
	 * @return \SplFixedArray SplFixedArray of Ratings found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public function getRatingByRatingTrailId(\PDO $pdo, $ratingTrailId) : \SplFixedArray{
		try {
			$ratingTrailId = self::validateUuid($ratingTrailId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT ratingProfileId, ratingTrailId, ratingValue, ratingDifficulty FROM rating WHERE ratingTrailId = :ratingTrailId";
		$statement = $pdo->prepare($query);
		// bind the rating trail id to the place holder in the template
		$parameters = ["ratingTrailId" => $ratingTrailId->getBytes()];
		$statement->execute($parameters);
		// build an array of ratings
		$ratings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false){
			try {
				$rating = new Rating($row["ratingProfileId"], $row["ratingTrailId"],$row["ratingValue"],$row["ratingDifficulty"]);
				$ratings[$ratings->key()] = $rating;
				$ratings->next();
			} catch(\Exception $exception){
				// if the row couldn't be converted, rethrow it
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($ratings);
	}
}