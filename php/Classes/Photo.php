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
		$this->setTweetProfileId($newPhotoProfileUserId);
		$this->setTweetContent($newPhotoUrl);
		$this->setTweetDate($newPhotoDateTime);
	}
	//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}
	public function __construct($newPhotoId, $newPhotoProfileUserId, string $newPhotoUrl, $newPhotoDateTime = null) {
	try {
		$this->setTweetId($newPhotoId);
		$this->setTweetProfileId($newPhotoProfileUserId);
		$this->setTweetContent($newPhotoUrl);
		$this->setTweetDate($newPhotoDateTime);
	}
		//determine what exception type was thrown
	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	/**
	 * accessor method for photo id
	 *
	 * @return Uuid value of tweet id
	 **/
	public function getTweetId() : Uuid {
		return($this->tweetId);
	}

	/**
	 * mutator method for tweet id
	 *
	 * @param Uuid|string $newTweetId new value of tweet id
	 * @throws \RangeException if $newTweetId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 **/
	public function setTweetId( $newTweetId) : void {
		try {
			$uuid = self::validateUuid($newTweetId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the tweet id
		$this->tweetId = $uuid;
	}

	/**
	 * accessor method for tweet profile id
	 *
	 * @return Uuid value of tweet profile id
	 **/
	public function getTweetProfileId() : Uuid{
		return($this->tweetProfileId);
	}

	/**
	 * mutator method for tweet profile id
	 *
	 * @param string | Uuid $newTweetProfileId new value of tweet profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newTweetProfileId is not an integer
	 **/
	public function setTweetProfileId( $newTweetProfileId) : void {
		try {
			$uuid = self::validateUuid($newTweetProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->tweetProfileId = $uuid;
	}