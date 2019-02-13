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
class Trail {
	//use ValidateDate;
	use ValidateDate;

	//use ValidateUuid;
	use ValidateUuid;

	/**
	 * id for this Trail; this is a primary key
	 * @var Uuid $trailId
	 **/
	private $trailId;
	/**
	 * url for this Trail avatar photo
	 * @var Url $trailAvatarUrl
	 **/
	private $trailAvatarUrl;
	/**
	 * description of this Trail, to be included with Trail name
	 * @var string $trailDescription
	 **/
	private $trailDescription;
	/**
	 * measure of the highest point of the Trail in feet
	 * @var string $trailHigh
	 **/
	private $trailHigh;
	/**
	 * measure of the latitude coordinate of the Trail, in degrees/minutes/seconds
	 * @var string $trailLatitude
	 **/
	private $trailLatitude;
	/**
	 * measure of the length of the Trail, in miles
	 * @var float $trailLength
	 **/
	private $trailLength;
	/**
	 * measure of the longitude of the Trail, in degrees/minutes/seconds
	 * @var string $trailLongitude
	 **/
	private $trailLongitude;
	/**
	 * measure of the lowest point of the Trail in feet
	 * @var string $trailLow
	 **/
	private $trailLow;
	/**
	 * the name of this Trail
	 * @var string $trailName
	 **/
	private $trailName;

	/**
	 * constructor for this Trail class
	 *
	 * @param string|Uuid $trailId, id of this Trail
	 * @param string|Url $trailAvatarUrl, url of this Trail's avatar picture
	 * @param string $trailDescription, description of this Trail
	 * @param string $trailHigh, measure of the highest point of this Trail in feet
	 * @param string $trailLatitude, measure of this Trail in degrees/minutes/seconds
	 * @param float $trailLength, measure of this Trail in miles
	 * @param string $trailLongitude, measure of this Trail in degrees/minutes/seconds
	 * @param string $trailLow, measure of the lowest point of this Trail in feet
	 * @param string $trailName, the name of this Trail
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if the data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \ArgumentCountError when too few arguments are passed to the user-defined function
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other type of exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($trailId, $trailAvatarUrl, $trailDescription, $trailHigh, $trailLatitude, $trailLength, $trailLongitude, $trailLow, $trailName) {
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
		catch(\InvalidArgumentException | \RangeException | \ArgumentCountError | \TypeError | \Exception $exception) {
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
	public function setTrailId($newTrailId) {
		try {
			$uuid = self::validateUuid($newTrailId);
		} catch(\InvalidArgumentException | \RangeException | \ArgumentCountError | \TypeError | \Exception $exception) {
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
	public function getTrailAvatarUrl() : Url {
		return($this->trailAvatarUrl);
	}

	/**
	 * mutator method for trail avatar url
	 *
	 * @param Url|string $newTrailAvatarUrl new value of trail avatar url
	 * @throws \InvalidArgumentException if $newTrailAvatarUrl uses invalid characters
	 * @throws \TypeError if $newTrailAvatarUrl is not a string
	 **/
	public function setTrailAvatarUrl($newTrailAvatarUrl) {
			//verify the url is secure
			$newTrailAvatarUrl = trim($newTrailAvatarUrl);
			$newTrailAvatarUrl = filter_var($newTrailAvatarUrl, FILTER_SANITIZE_URL);
			if(empty($newTrailAvatarUrl) === true) {
				throw(new\InvalidArgumentException("url is empty or insecure"));
			}

			//store the url
			$this->trailAvatarUrl = $newTrailAvatarUrl;
	}

	/**
	 * accessor method for trail description
	 *
	 * @return string single sentence description of trail
	 **/
	public function getTrailDescription() {
		return($this->trailDescription);
	}

	/**
	 * mutator method for trail description
	 *
	 * @param string $newTrailDescription new value of trail description
	 * @throws \InvalidArgumentException if $newTrailDescription uses invalid characters
	 * @throws \TypeError if $newTrailDescription is not a string
	 **/
	public function setTrailDescription($newTrailDescription) {
		//verify description is secure
		$newTrailDescription = trim($newTrailDescription);
		$newTrailDescription = filter_var($newTrailDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTrailDescription) === true) {
			throw(new \InvalidArgumentException("description is empty or insecure"));
		}

		//store the description
		$this->trailDescription = $newTrailDescription;
	}

	/**
	 * accessor methor for trail high
	 *
	 * @return string highest point of trail measured in feet
	 **/
	public function getTrailHigh(): string {
		return $this->trailHigh;
	}

	/**
	 * mutator method for trail high
	 *
	 * @param string $newTrailHigh new value of trail highest point
	 * @throws \InvalidArgumentException if $newTrailHigh uses invalid characters
	 * @throws \RangeException if $newTrailHigh is negative, zero or null
	 * @throws \TypeError if $newTrailHigh is not a string
	 **/
	public function setTrailHigh($newTrailHigh) {
		//verify that trail highest point data is secure
		$newTrailHigh = trim($newTrailHigh);
		$newTrailHigh = filter_var($newTrailHigh, FILTER_SANITIZE_NUMBER_INT);
		if(empty($newTrailHigh) === true) {
			throw(new \InvalidArgumentException("highest point data is empty or insecure"));
		}

		//store the highest point data
		$this->trailHigh = $newTrailHigh;
	}

	/**
	 * accessor method for trail latitude
	 *
	 * @return string trail latitude in degrees, minutes, seconds
	 **/
	public function getTrailLatitude() {
		return $this->trailLatitude;
	}

	/**
	 * mutator method for trail latitude
	 *
	 * @param string $newTrailLatitude new value of the trail latitude
	 * @throws \InvalidArgumentException if $newTrailLatitude uses invalid characters
	 * @throws \TypeError if $newTrailLatitude is not a string
	 **/
	public function setTrailLatitude($newTrailLatitude) {
		//verify that trail latitude data is secure
		$newTrailLatitude = trim($newTrailLatitude);
		$newTrailLatitude = filter_var($newTrailLatitude, FILTER_SANITIZE_NUMBER_FLOAT);
		if(empty($newTrailLatitude) === true) {
			throw(new \InvalidArgumentException("latitude data is empty or insecure"));
		}

		//store the latitude data
		$this->trailLatitude = $newTrailLatitude;
	}

	/**
	 * accessor method for trail length
	 *
	 * @return string|float trail length in miles
	 **/
	public function getTrailLength() {
		return $this->trailLength;
	}

	/**
	 * mutator method for trail length
	 *
	 * @param string|float $newTrailLength new value of the trail length
	 * @throws \InvalidArgumentException if $newTrailLength uses invalid characters
	 * @throws \RangeException if $newTrailLength is a negative number, zero or null
	 * @throws \TypeError if $newTrailLength is not a string
	 **/
	public function setTrailLength($newTrailLength) {
		//verify that trail length data is secure
		$newTrailLength = trim($newTrailLength);
		$newTrailLength = filter_var($newTrailLength, FILTER_SANITIZE_NUMBER_INT);
		if(empty($newTrailLength) === true) {
			throw(new \InvalidArgumentException("length is empty or insecure"));
		}

		//store the length data
		$this->trailLength = $newTrailLength;
	}

	/**
	 * accessor method for trail longitude
	 *
	 * @return string|float trail longitude in degrees, minutes, seconds
	 **/
	public function getTrailLongitude() {
		return $this->trailLongitude;
	}

	/**
	 * mutator method for trail longitude
	 *
	 * @param string|float $newTrailLongitude new value of the trail longitude
	 * @throws \InvalidArgumentException if $newTrailLongitude uses invalid characters
	 * @throws \TypeError if $newTrailLongitude is not a string
	 **/
	public function setTrailLongitude($newTrailLongitude) {
		//verfiy that trail longitude data is secure
		$newTrailLongitude = trim($newTrailLongitude);
		$newTrailLongitude = filter_var($newTrailLongitude, FILTER_SANITIZE_NUMBER_FLOAT);
		if(!is_float($newTrailLongitude)) {
			throw(new \InvalidArgumentException("longitude is empty or insecure"));
		}

		//store longitude data
		$this->trailLongitude = $newTrailLongitude;
	}

	/**
	 * accessor method for trail lowest point
	 *
	 * @return string trail lowest point in feet
	 **/
	public function getTrailLow() {
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
	public function setTrailLow($newTrailLow) {
		$newTrailLow = trim($newTrailLow);
		$newTrailLow = filter_var($newTrailLow, FILTER_SANITIZE_NUMBER_INT);
		if(!is_integer($newTrailLow) ) {
			throw(new \InvalidArgumentException("lowest point data is not a number or insecure"));
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
	public function setTrailName($newTrailName) {
		$newTrailName = trim($newTrailName);
		$newTrailName = filter_var($newTrailName, FILTER_SANITIZE_STRING);
		if(empty($newTrailName) === true) {
			throw(new \InvalidArgumentException("name is empty or insecure"));
		}

		//store trail name
		$this->trailName = $newTrailName;
	}
}
