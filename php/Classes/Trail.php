<?php
namespace CapstoneTrails\AbqTrails;

//our autoloader
require_once("autoload.php");
//composer autoloader
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Trail Class
 *
 * This is a Class that stores data for a Trail in the ABQ Trails app.
 *
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.0.0
 **/
class Trail implements \JsonSerializable {

	use ValidateDate;
	use ValidateUuid;

	/**
	 * id for Trail; this is a primary key
	 * @var Uuid $trailId
	 **/
	private $trailId;
	/**
	 * url for Trail avatar photo
	 * @var string $trailAvatarUrl
	 **/
	private $trailAvatarUrl;
	/**
	 * description of Trail
	 * @var string $trailDescription
	 **/
	private $trailDescription;
	/**
	 * measure of the highest point of the Trail in feet
	 * @var int $trailHigh
	 **/
	private $trailHigh;
	/**
	 * measure of the latitude coordinate of the Trail in degrees
	 * @var float $trailLatitude
	 **/
	private $trailLatitude;
	/**
	 * measure of the length of the Trail in miles
	 * @var float $trailLength
	 **/
	private $trailLength;
	/**
	 * measure of the longitude of the Trail in degrees
	 * @var float $trailLongitude
	 **/
	private $trailLongitude;
	/**
	 * measure of the lowest point of the Trail in feet
	 * @var int $trailLow
	 **/
	private $trailLow;
	/**
	 * name of Trail
	 * @var string $trailName
	 **/
	private $trailName;

	/**
	 * constructor for this Trail class
	 *
	 * @param string|Uuid $trailId, id of this Trail
	 * @param string $trailAvatarUrl, url of this Trail's avatar picture
	 * @param string $trailDescription, description of this Trail
	 * @param int $trailHigh, measure of the highest point of this Trail in feet
	 * @param float $trailLatitude, measure of this Trail in degrees/minutes/seconds
	 * @param float $trailLength, measure of this Trail in miles
	 * @param float $trailLongitude, measure of this Trail in degrees/minutes/seconds
	 * @param int $trailLow, measure of the lowest point of this Trail in feet
	 * @param string $trailName, the name of this Trail
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if the data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other type of exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($trailId, string $trailAvatarUrl, ?string $trailDescription, ?string $trailHigh, $trailLatitude, $trailLength, $trailLongitude, ?string $trailLow, string $trailName) {
		try {
			$this->setTrailId($trailId);
			$this->setTrailAvatarUrl($trailAvatarUrl);
			$this->setTrailDescription($trailDescription);
			$this->setTrailHigh($trailHigh);
			$this->setTrailLatitude($trailLatitude);
			$this->setTrailLength($trailLength);
			$this->setTrailLongitude($trailLongitude);
			$this->setTrailLow($trailLow);
			$this->setTrailName($trailName);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for trail id
	 *
	 * @return Uuid value of trail id
	 **/
	public function getTrailId() : Uuid {
		return($this->trailId);
	}

	/**
	 * mutator method for trail id
	 *
	 * @param Uuid|string $newTrailId new value of trail id
	 * @throws \RangeException if $newTrailId is not positive
	 * @throws \TypeError if $newTrailId is not a uuid or string
	 **/
	public function setTrailId($newTrailId) : void {
		try {
			$uuid = self::validateUuid($newTrailId);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the trail id
		$this->trailId = $uuid;
	}

	/**
	 * accessor method for trail avatar url
	 *
	 * @return string url address of the trail avatar picture
	 **/
	public function getTrailAvatarUrl() : string {
		return($this->trailAvatarUrl);
	}

	/**
	 * mutator method for trail avatar url
	 *
	 * @param string $newTrailAvatarUrl new value of trail avatar url
	 * @throws \InvalidArgumentException if $newTrailAvatarUrl uses invalid characters or is too big
	 * @throws \TypeError if $newTrailAvatarUrl is not a string
	 **/
	public function setTrailAvatarUrl($newTrailAvatarUrl) : void {
			if($newTrailAvatarUrl === null) {
				$this->trailAvatarUrl = null;
			}

			//verify the url right size and secure
			$newTrailAvatarUrl = trim($newTrailAvatarUrl);
			$newTrailAvatarUrl = filter_var($newTrailAvatarUrl, FILTER_SANITIZE_URL);

			if(empty($newTrailAvatarUrl) > 255) {
				throw(new \InvalidArgumentException("url is too large or insecure"));
			}

			//store the url
			$this->trailAvatarUrl = $newTrailAvatarUrl;
	}

	/**
	 * accessor method for trail description
	 *
	 * @return string single sentence description of trail
	 **/
	public function getTrailDescription() : string {
		return($this->trailDescription);
	}

	/**
	 * mutator method for trail description
	 *
	 * @param string $newTrailDescription new value of trail description
	 * @throws \InvalidArgumentException if $newTrailDescription uses invalid characters
	 * @throws \TypeError if $newTrailDescription is not a string
	 **/
	public function setTrailDescription(?string $newTrailDescription) : void {
		if($newTrailDescription === null) {
			$this->trailDescription = null;
		}

		//verify description is not too big and secure
		$newTrailDescription = trim($newTrailDescription);
		$newTrailDescription = filter_var($newTrailDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if($newTrailDescription > 280) {
			throw(new \InvalidArgumentException("description is too large or insecure"));
		}

		//store the description
		$this->trailDescription = $newTrailDescription;
	}

	/**
	 * accessor method for trail high
	 *
	 * @return int highest point of trail measured in feet
	 **/
	public function getTrailHigh(): int {
		return $this->trailHigh;
	}

	/**
	 * mutator method for trail high
	 *
	 * @param int $newTrailHigh new value of trail highest point
	 * @throws \RangeException if $newTrailHigh is negative, zero or null
	 **/

	public function setTrailHigh(?int $newTrailHigh) : void {
		//verify that trail highest point data is valid and secure
		$newTrailHigh = trim($newTrailHigh);
		$newTrailHigh = filter_var($newTrailHigh, FILTER_SANITIZE_NUMBER_INT);

		if($newTrailHigh <= 0 || $newTrailHigh >= 32767) {
			throw(new \RangeException("trail high is out of range"));
		}

		//store the highest point data
		$this->trailHigh = $newTrailHigh;
	}

	/**
	 * accessor method for trail latitude
	 *
	 * @return float Trail latitude in degrees between -90 and 90
	 **/
	public function getTrailLatitude() : float {
		return $this->trailLatitude;
	}

	/**
	 * mutator method for trail latitude
	 *
	 * @param float $newTrailLatitude new value of the trail latitude
	 * @throws \RangeException if $newTrailLatitude is outside of range
	 **/
	public function setTrailLatitude($newTrailLatitude) : void {
		//verify that trail latitude is valid and secure
		$newTrailLatitude = trim($newTrailLatitude);
		$newTrailLatitude = filter_var($newTrailLatitude, FILTER_SANITIZE_NUMBER_FLOAT);

		if($newTrailLatitude < -90 || $newTrailLatitude > 90) {
			throw(new \RangeException("trail latitude is out of range"));
		}

		//store the latitude data
		$this->trailLatitude = $newTrailLatitude;
	}

	/**
	 * accessor method for trail length
	 *
	 * @return float Trail length in miles
	 **/
	public function getTrailLength() : float {
		return $this->trailLength;
	}

	/**
	 * mutator method for trail length
	 *
	 * @param float $newTrailLength new value of the trail length\
	 * @throws \RangeException if $newTrailLength is a negative number, zero or null\
	 **/
	public function setTrailLength($newTrailLength) : void {
		//verify that trail length data is valid and secure
		$newTrailLength = trim($newTrailLength);
		$newTrailLength = filter_var($newTrailLength, FILTER_SANITIZE_NUMBER_FLOAT);

		if($newTrailLength <= 0) {
			throw(new \RangeException("trail length is less than zero"));
		}

		//store the length data
		$this->trailLength = $newTrailLength;
	}

	/**
	 * accessor method for trail longitude
	 *
	 * @return float Trail longitude in degrees between -180 and 180
	 **/
	public function getTrailLongitude() : float {
		return $this->trailLongitude;
	}

	/**
	 * mutator method for trail longitude
	 *
	 * @param float $newTrailLongitude new value of the trail longitude
	 * @throws \RangeException if $newTrailLongitude is outside of range
	 **/
	public function setTrailLongitude($newTrailLongitude) : void {
		//verify that trail longitude is valid and secure
		$newTrailLongitude = trim($newTrailLongitude);
		$newTrailLongitude = filter_var($newTrailLongitude, FILTER_SANITIZE_NUMBER_FLOAT);

		if($newTrailLongitude < -180 || $newTrailLongitude > 180) {
			throw(new \RangeException("trail longitude is out of range"));
		}

		//store the latitude data
		$this->trailLongitude = $newTrailLongitude;
	}

	/**
	 * accessor method for trail lowest point
	 *
	 * @return int trail lowest point in feet
	 **/
	public function getTrailLow() : int {
		return $this->trailLow;
	}

	/**
	 * mutator method for trail lowest point
	 *
	 * @param string $newTrailLow new value of the trail lowest point
	 * @throws \InvalidArgumentException if $newTrailLow uses invalid characters
	 * @throws \RangeException if $newTrailLow is negative, zero or null
	 * @throws \TypeError if $newTrailLow is not a string
	 **/
	public function setTrailLow(?int $newTrailLow) {
		//verify that trail highest point data is valid and secure
		$newTrailLow = trim($newTrailLow);
		$newTrailLow = filter_var($newTrailLow, FILTER_SANITIZE_NUMBER_INT);

		if($newTrailLow <= 0 || $newTrailLow >= 32767) {
			throw(new \RangeException("lowest point data is out of range"));
		}

		//store trail lowest point data
		$this->trailLow = $newTrailLow;
	}

	/**
	 * accessor method for trail name
	 *
	 * @return string name of the trail
	 **/
	public function getTrailName() : string {
		return $this->trailName;
	}

	/**
	 * mutator method for trail name
	 *
	 * @param string $newTrailName new value of the trail name
	 * @throws \InvalidArgumentException if $newTrailName uses invalid characters
	 * @throws \TypeError if $newTrailName is not a string
	 **/
	public function setTrailName(string $newTrailName) {
		$newTrailName = trim($newTrailName);
		$newTrailName = filter_var($newTrailName, FILTER_SANITIZE_STRING);
		if(empty($newTrailName) === true) {
			throw(new \InvalidArgumentException("name is empty or insecure"));
		}

		//store trail name
		$this->trailName = $newTrailName;
	}
//todo add insert update delete getTrailbyTrailId getTrailbyName getTrailbyLength getTrailByRating?? getTrailByDistance??
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["trailId"] = $this->trailId->toString();
		return($fields);
	}


}
