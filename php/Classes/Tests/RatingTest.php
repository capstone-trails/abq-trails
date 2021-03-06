<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\{Rating, Profile, Trail};

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
	 * Profile from profile/rating relationship, foreign key
	 * @var Profile $profile
	 */
	protected $profile = null;
	/**
	 * Trail from trail/rating relationship, foreign key
	 */
	protected $trail = null;

	protected $VALID_PROFILE_ACTIVATION;

	protected $VALID_PROFILE_HASH;
	/**
	 * valid rating Difficulty
	 * @var int $VALID_DIFFICULTY
	 **/
	protected $VALID_DIFFICULTY = 3;
	/**
	 * content of the updated difficulty
	 * @var int $VALID_DIFFICULTY_2
	 **/
	protected $VALID_DIFFICULTY_2 = 1;
	/**
	 * valid rating about to use
	 * @var int $VALID_VALUE
	 **/
	protected $VALID_VALUE = 5;
	/**
	 * content of the updated Rating
	 * @var int $VALID_VALUE_2
	 **/
	protected $VALID_VALUE_2 = 3;


	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		parent::setUp();
		$password = "heythere123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILE_ACTIVATION = bin2hex(random_bytes(16));
		//create and insert a profile
		$this->profile = new Profile(generateUuidV4(), $this->VALID_PROFILE_ACTIVATION, "www.blahblah.com/12222", "myname@man.com", "Matt", $this->VALID_PROFILE_HASH, "Damon", "mattDamon");
		$this->profile->insert($this->getPDO());
		//create and insert trail from trail tag
		$this->trail = new Trail(generateUuidV4(), "www.faketrail.com/photo", "This trail is a fine trail", 1234, 35.0792, 5.2, 106.4847, 1254, "Copper Canyon");
		$this->trail->insert($this->getPDO());
	}


	/**
	 * test inserting a valid Rating and verify that the actual mySQL matches
	 **/
	public function testInsertValidRating(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileIdAndRatingTrailId($this->getPDO(), $this->profile->getProfileId(), $this->trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRating->getRatingTrailId(), $this->trail->getTrailId());
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
	}


	/**
	 * test inserting a Rating, editing it and then updating it
	 **/
	public function testUpdateValidRating() {
		// count the number of number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		// create a new Rating and insert to into mySQL
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		// edit the rating update it in mySQL
		$rating->setRatingDifficulty($this->VALID_DIFFICULTY_2);
		$rating->setRatingValue($this->VALID_VALUE_2);
		$rating->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileIdAndRatingTrailId($this->getPDO(), $this->profile->getProfileId(), $this->trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY_2);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE_2);
	}


	/**
	 * test creating a Rating and then deleting it
	 **/
	public function testDeleteValidRating(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		//create a new rating and insert it into mySQL
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		// delete the Rating from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$rating->delete($this->getPDO());
		// grab the data from mySQL and enforce the Rating does not exist
		$pdoRating = Rating::getRatingByRatingProfileIdAndRatingTrailId($this->getPDO(), $this->profile->getProfileId(), $this->trail->getTrailId());
		$this->assertNull($pdoRating);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("rating"));
	}


	/**
	 * test inserting a Rating and regrabbing it from mySQL
	 **/
	public function testGetValidRatingByRatingProfileIdAndRatingTrailId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileIdAndRatingTrailId($this->getPDO(), $this->profile->getProfileId(), $this->trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRating->getRatingTrailId(), $this->trail->getTrailId());
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
	}


	/**
	 * test inserting a Rating and regrabbing it from mySQL
	 **/
	public function testGetValidRatingByRatingProfileId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRating->getRatingTrailId(), $this->trail->getTrailId());
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
	}


	/**
	 * test inserting a Rating and regrabbing it from mySQL
	 **/
	public function testGetValidRatingByRatingTrailId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRating = Rating::getRatingByRatingTrailId($this->getPDO(), $this->trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertEquals($pdoRating->getRatingProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRating->getRatingTrailId(), $this->trail->getTrailId());
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
	}


	/**
	 * test grabbing a rating by rating value
	 **/
	public function testGetValidRatingByValue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");
		//create a new rating and insert it into mySQL
		$rating = new Rating($this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_DIFFICULTY, $this->VALID_VALUE);
		$rating->insert($this->getPDO());
		//grab the data from MySQL
		$results = Rating::getRatingByRatingValue($this->getPDO(), $rating->getRatingValue());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertCount(1, $results);
		//enforce no other objects bleed into the test
		$this->assertContainsOnlyInstancesOf("CapstoneTrails\\AbqTrails\\Rating", $results);
		//grab the result from the array and validate it
		$pdoRating = $results[0];
		$this->assertEquals($pdoRating->getRatingProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRating->getRatingTrailId(), $this->trail->getTrailId());
		$this->assertEquals($pdoRating->getRatingDifficulty(), $this->VALID_DIFFICULTY);
		$this->assertEquals($pdoRating->getRatingValue(), $this->VALID_VALUE);
	}
}