<?php
namespace abqtrails;
use mysql_xdevapi\Exception;
use Ramsey\Uuid\Uuid;

/**
 * Class rating
 * @package abqtrails
 *
 * @author Robert Dominguez <rdominguez45@cnm.edu
 **/
class rating {
	/**
	 * id for this Rating; this is the primary key
	 * @var Uuid $ratingId
	 **/
	private $ratingId;
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
	 * @param string|Uuid $newRatingId id of this rating or null if a new rating
	 * @param string|Uuid $newRatingProfileId id of the profile that's making the rating
	 * @param string|Uuid $newRatingTrailId id of the trail that's being rated
	 * @param string $newRatingDifficulty string that tells how difficult the trail is
	 * @param string $newRatingValue string that tells what might be on the trails.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if some other exception occurs
	 * @Documention https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newRatingId, $newRatingProfileId, $newRatingTrailId, string $newRatingDifficulty, string $newRatingValue) {
		try {
			$this->ratingId($newRatingId);
			$this->ratingProfileId($newRatingProfileId);
			$this->ratingTrailId($newRatingTrailId);
			$this->ratingDifficulty($newRatingDifficulty);
			$this->ratingValue($newRatingValue);
		} // determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for rating id
	 *
	 * @return Uuid value of rating id
	 **/
	public function getRating(): Uuid {
		return ($this->ratingId);
	}

	/**
	 * mutator method for rating id
	 *
	 * @param Uuid|string $newRatingId
	 * @throws \RangeException if $newRatingId
	 * @throws \TypeError if $newRatingId is not a uuid or string
	 **/
	public function setRatingId($newRatingId): void {
		try {
			$uuid = self::validateUuid($newRatingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the rating id
		$this->ratingId = $uuid;
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
		return ($this->RatingDifficulty);
	}

	/**
	 * mutator method for rating difficulty
	 *
	 * @param string $newRatingDifficulty
	 * @throws \InvalidArgumentException if $newRatingDifficulty
	 * @throws \RangeException if $newRatingDifficulty
	 * @throws \TypeError if $newRatingDifficulty is not a string
	 **/
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
		return ($this->RatingValue);
	}
}