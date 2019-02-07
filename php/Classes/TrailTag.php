<?php
namespace abqtrails;
/**
 *
 * This profile is used to input and view data and photos on ABQ Trails web application
 *
 * @author Cassandra Romero <cromero278@cnm.edu>
 *
 */
class TrailTag {
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

}