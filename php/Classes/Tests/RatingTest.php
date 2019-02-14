<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Rating;

//our autoloader
require_once(dirname(__DIR__, 1) . "/autoload.php");

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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
	 * @var int $VALID_DIFFICULTY
	 **/
	protected $VALID_DIFFICULTY = 3;
	/**
	 * content of the updated difficulty
	 * @var int $VALID_DIFFICULTY_2
	 **/
	protected $VALID_DIFFICULTY_2 = 4;


	/**
	 * test inserting a valid Rating and verify that the actual mySQL matches
	 **/
	public function testInsertValidRating() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$ratingProfileId = generateUuidV4();
		$ratingTrailId = generateUuidV4();
		$rating = new Rating($ratingProfileId, $ratingTrailId, $this->VALID_VALUE, $this->VALID_DIFFICULTY);
		$rating ->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileIdAndRatingTrailId($this->getPDO(), $rating-> getRatingProfileId() AND $rating-> getRatingTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY);
	}


	/**
	 * test inserting a Rating, editing it and then updating it
	 **/
	public function testUpdateValidRating(){
		// count the number of number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		// create a new Rating and insert to into mySQL
		$ratingProfileId = generateUuidV4();
		$ratingTrailId = generateUuidV4();
		$rating = new Rating($ratingProfileId, $ratingTrailId, $this->VALID_VALUE, $this->VALID_VALUE_2, $this->VALID_DIFFICULTY, $this->VALID_DIFFICULTY_2);
		$rating->insert($this->getPDO());
		// edit the rating update it in mySQL
		$rating->setRatingValue($this->VALID_VALUE);
		$rating->setRatingValue2($this->VALID_VALUE_2);
		$rating->setRatingDifficulty($this->VALID_DIFFICULTY);
		$rating->setRatingDifficulty2($this->VALID_DIFFICULTY_2);
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileId($this->getPDO(),$rating->getRatingProfileId());
		$pdoRating = Rating::getRatingByRatingTrailId($this->getPDO(),$rating->getRatingTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $ratingProfileId);
		$this->assertEquals($pdoRating->getRatingTrailId(), $ratingTrailId);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
		$this->assertEquals($pdoRating->getRatingValue2(), $this->VALID_VALUE_2);
		$this->assertEquals($pdoRating->getRatingDiffculty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingDiffculty2(), $this->VALID_DIFFICULTY_2);
	}


	/**
	 * test creating a Rating and then deleting it
	 **/
	public function testDeleteValidRating() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$ratingProfileId = generateUuidV4();
		$ratingTrailId = generateUuidV4();
		$rating = new Rating($ratingProfileId, $ratingTrailId, $this->VALID_VALUE, $this->VALID_VALUE_2, $this->VALID_DIFFICULTY, $this->VALID_DIFFICULTY_2);
		$rating->insert($this->getPDO());
		// delete the Rating from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$rating->delete($this->getPDO());
		// grab the data from mySQL and enforce the Rating does not exist
		$pdoRating = Rating::getRatingByRatingProfileId($this->getPDO(), $rating->getRatingId());
		$pdoRating = Rating::getRatingByRatingTrailId($this->getPDO(), $rating->getRatingId());
		$this->assertNull($pdoRating);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("rating"));
	}


	/**
	 * test inserting a Rating and regrabbing it from mySQL
	 **/
	public function testGetValidRatingByRatingProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$ratingProfileId = generateUuidV4();
		$ratingTrailId = generateUuidV4();
		$rating = new Rating($ratingProfileId, $ratingTrailId, $this->VALID_VALUE, $this->VALID_VALUE_2, $this->VALID_DIFFICULTY, $this->VALID_DIFFICULTY_2);
		$rating->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileId($this->getPDO(), $rating->getRatingId());
		$pdoRating = Rating::getRatingByRatingTrailId($this->getPDO(), $rating->getRatingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $ratingProfileId);
		$this->assertEquals($pdoRating->getRatingTrailId(), $ratingTrailId);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
		$this->assertEquals($pdoRating->getRatingValue2(), $this->VALID_VALUE_2);
		$this->assertEquals($pdoRating->getRatingDiffculty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingDiffculty2(), $this->VALID_DIFFICULTY_2);
	}


	/**
	 * test grabbing a Rating that does not exist
	 **/
	public function testGetInvalidRatingByRating() : void {
		// grab a rating id that exceeds the maximum allowable profile id
		$fakeRatingId = generateUuidV4();
		$rating = Profile::getRatingByRatingProfileId($this->getPDO(), $fakeRatingId );
		$rating = Profile::getRatingByRatingTrailId($this->getPDO(), $fakeRatingId );
		$this->assertNull($rating);
	}


	/**
	 * test grabbing a rating by rating value
	 **/
	public function testGetValidRatingByValue(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$ratingProfileId = generateUuidV4();
		$ratingTrailId = generateUuidV4();
		$rating = new Rating($ratingProfileId, $ratingTrailId, $this->VALID_VALUE, $this->VALID_VALUE_2, $this->VALID_DIFFICULTY, $this->VALID_DIFFICULTY_2);
		$rating->insert($this->getPDO());
		//grab the data from MySQL
		$pdoRating = Rating::getRatingByRatingValue($this->getPDO(), $rating->getRatingValue());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $ratingProfileId);
		$this->assertEquals($pdoRating->getRatingTrailId(), $ratingTrailId);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
		$this->assertEquals($pdoRating->getRatingValue2(), $this->VALID_VALUE_2);
		$this->assertEquals($pdoRating->getRatingDiffculty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingDiffculty2(), $this->VALID_DIFFICULTY_2);
	}
}