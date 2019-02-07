<?php
namespace abqtrails;

use http\Exception\InvalidArgumentException;
use http\Url;

/**
 * Trail Class
 *
 * This is a Class that stores data for a Trail in the ABQ Trails app.
 *
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.0.0
 **/
class Trail {

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










}
