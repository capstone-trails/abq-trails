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
class TrailTag {
	use ValidateUuid;
/**
 * this is the id that connects the trail tag to the tag this is a primary key
 */
	private $trailTagTagId;
/**
 * this is the id that connects the trail tag to the trail this is a primary key
 */
	private $trailTagTrailId;
/**
 *this is the id that connects trail tag to the profile adding the tag this is a foreign key
 */
	private $trailTagProfileId;
/**
 * constructor for trailTag
 * @param string | Uuid $newTrailTagTagId Id that connects tag and trail tag
 * @param string | Uuid $newTrailTagTrailId Id that connects trail and trail tag
 * @param string | Uuid $newTrailTagProfileId Id that connects profiles and trail tag
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 */
	public function __construct($newTrailTagTagId, $newTrailTagTrailId, $newTrailTagProfileId) {
		try {
			$this->setTrailTagTagId($newTrailTagTagId);
			$this->setTrailTagTrailId($newTrailTagTrailId);
			$this->setTrailTagProfileId($newTrailTagProfileId);
		}
		catch(\InvalidArgumentException | \RangeException | \TypeError $exception){
			$exceptionType = get_class(($exception));
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
/**
 * accessor method for trail tad tag id
 *
 * @return Uuid for trail tag tag id
 */
	public function getTrailTagTagId() : Uuid {
		return($this->trailTagTagId);
	}
/**
 * mutator method for trail tag tag id
 *
 * @param Uuid | string $newTrailTagTagId value of trail tag tag id
 * @throws \RangeException if not exact length
 * @throws \InvalidArgumentException if empty
 * @throws \TypeError if not Uuid or string
 */
	public function setTrailTagTagId($newTrailTagTagId) : void {
		try{
			$uuid = self::validateUuid($newTrailTagTagId);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->trailTagTagId = $uuid;
	}

	/**
	 *accessor method for trail tag trail id
	 *
	 * @return Uuid value for trail tag trail id
	 */
	public function getTrailTagTrailId() : Uuid {
		return($this->trailTagTrailId);
	}
/**
 * mutator method for trail tag trail id
 * @param Uuid | string $newTrailTagTrailId
 * @throws \RangeException if not exact length
 * @throws \InvalidArgumentException if empty
 * @throws \TypeError if not Uuid or string
 */
	public function setTrailTagTrailId($newTrailTagTrailId) : void {
		try {
			$uuid = self::validateUuid($newTrailTagTrailId);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->trailTagTrailId = $uuid;
	}
/**
 * accessor method for trail tag profile id
 *
 * @return Uuid value of trail tag profile id
 */
	public function getTrailTagProfileId() : Uuid {
		return($this->trailTagProfileId);
	}
/**
 * mutator method for trail tag profile id
 * @param Uuid | string $newTrailTagProfileId
 * @throws \RangeException if not exact length
 * @throws \InvalidArgumentException if empty
 * @throws \TypeError if not Uuid or string
 */
	public function setTrailTagProfileId($newTrailTagProfileId) : void {
		try {
			$uuid = self::validateUuid($newTrailTagProfileId);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->trailTagProfileId = $uuid;
	}
	//todo add insert delete getTrailTagByTrailTrailIdAndTrailTagTagId getTrailTagByTagId getTrailByProfileId getTrailTagByTrailId
/**
* inserts this Profile into mySQL
*
* @param \PDO $pdo PDO connection object
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError if $pdo is not a PDO connection object
**/
	public function insert (\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO trailTag(trailTagTagId, trailTagTrailId, trailTagProfileId) VALUES :trailTagTagId, :trailTagTrailId, :trailTagProfileId";
		$statement = $pdo->prepare($query);

		//bind variables to place holders in the template
		$parameters = ["trailTagTagId" => $this->trailTagTagId, "trailTagTrailId" => $this->trailTagTrailId, "trailTagProfileId" => $this->trailTagProfileId];
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
	public function delete (\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM trailTag WHERE trailTagTagId = :trailTagTagId AND trailTagTrailId = :trailTagTrailId ";
		$statement = $pdo->prepare($query);

		//bind variable to place holders
		$parameters = ["trailTagTagId" => $this->trailTagTagId, "trailTagTrailId" => $this->trailTagTrailId, "trailTagProfileId" => $this->trailTagProfileId];
		$statement->execute($parameters);
	}
/**
 * gets the trailTag by the trail tag tag id and trail tag trail id
 * @param \PDO $pdo PDO connection object
 * @param string|uuid $trailTagTagId
 * @param string|Uuid $trailTagTrailId
 * @return \SplFixedArray of trail tags
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 *
 */
	public static function getTrailTagByTrailTagTagIdAndTrailTagTrailId (\PDO $pdo, Uuid $trailTagTagId, Uuid $trailTagTrailId) : \SplFixedArray{

	}
}