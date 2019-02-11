<?php
namespace CapstoneTrails\AbqTrails\Tests;

//use \abqtrails\Tag;

//grab the class under scrutiny
require_once(dirname(__DIR__, 1) . "/autoload.php");

/**
 * Full PHPUnit for the Rating class
 *
 * This is a complete PHPUnit Tests of the Rating class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Rating
 * @author Robert Dominguez
 **/
class RatingTest extends AbqTrailsTest {
	/**
	 * valid rating about to use
	 * @var string $VALID_VALUE
	 **/
	protected $VALID_VALUE = "Dog-Friendly";
	/**
	 * content of the updated Rating
	 * @var string $VALID_VALUE_2
	 **/
	protected $VALID_VALUE_2 = "Wheelchair accessible";
	/**
	 * valid rating Difficulty
	 * @var string $VALID_DIFFICULTY
	 **/
	protected $VALID_DIFFICULTY = "Medium";
	/**
	 * content of the updated difficulty
	 * @var string $VALID_DIFFICULTY_2
	 **/
	protected $VALID_DIFFICULTY_2 = "Hard";

	/**
	 * test inserting a valid Rating and verify that the actual mySQL matches
	 **/
	public function testInsertValidRating() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Rating");
		$ratingId = generateUuidV4();
		$rating = new Rating($ratingId, $this->VALID_VALUE, $this->VALID_VALUE_2, $this->VALID_DIFFICULTY, $this->VALID_DIFFICULTY_2);
		$rating ->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingId($this->getPDO(), $rating->getRatingProfileId())
	}
}