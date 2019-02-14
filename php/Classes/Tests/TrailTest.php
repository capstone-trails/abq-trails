<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Trail;

//our autoloader
require_once(dirname(__DIR__) . "/autoload.php");

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit Tests for the Trail class
 *
 * This is a complete PHPUnit Tests of the Trail class. It is complete because *ALL* mySQL/PDO enabled methods are tested
 * for both invalid and valid inputs.
 *
 * @see \CapstoneTrails\AbqTrails\Trail
 * @author Scott Wells <swells19@cnm.edu>
 **/

class TrailTest extends AbqTrailsTest {
	/**
	 * valid trail avatar url to use
	 * @var string $VALID_TRAIL_AVATAR_URL
	 **/
	protected $VALID_TRAIL_AVATAR_URL = "https://www.fs.usda.gov/Internet/FSE_MEDIA/fseprd563249.jpg";
	/**
	 * content of the updated avatar url
	 * @var string $VALID_TRAIL_AVATAR_URL
	 **/
	protected $VALID_TRAIL_AVATAR_URL_2 = "https://www.fs.usda.gov/Internet/FSE_MEDIA/fseprd563247.jpg";
	/**
	 * valid trail description to use
	 * @var string $VALID_TRAIL_DESCRIPTION
	 **/
	protected $VALID_TRAIL_DESCRIPTION = "Located on the west face of the Sandia Mountains";
	/**
	 * valid trail description to use
	 * @var string $VALID_TRAIL_DESCRIPTION
	 **/
	protected $VALID_TRAIL_DESCRIPTION_2 = "Heavily trafficked out and back trail located near Albuquerque, NM";
	/**
	 * valid trail highest elevation in feet
	 * @var string $VALID_TRAIL_HIGH
	 **/
	protected $VALID_TRAIL_HIGH = 10378;
	/**
	 * valid trail latitude coordinate
	 * @var string $VALID_TRAIL_LATITUDE
	 **/
	protected $VALID_TRAIL_LATITUDE = 35.2197;
	/**
	 * valid trail length
	 * @var string $VALID_TRAIL_LENGTH
	 **/
	protected $VALID_TRAIL_LENGTH = 13.3;
	/**
	 * valid trail longitude coordinate
	 * @var string $VALID_TRAIL_LONGITUDE
	 **/
	protected $VALID_TRAIL_LONGITUDE = 106.4808;
	/**
	 * valid trail lowest elevation in feet
	 * @var string $VALID_TRAIL_LOW
	 **/
	protected $VALID_TRAIL_LOW = 7060;
	/**
	 * valid trail name
	 * @var string $VALID_TRAIL_NAME
	 **/
	protected $VALID_TRAIL_NAME = "La Luz Trail";
	/**
	 * valid trail name
	 * @var string $VALID_TRAIL_NAME
	 **/
	protected $VALID_TRAIL_NAME_2 = "La Luz Trailhead";

	/**
	 * run the setUp operation to create secure user and hash password
	 **/
//	public final function setUp(): void {
//		//create and insert a Trail to test against
//		$this->trail = new Trail(
//			generateUuidV4(),
//			"https://www.fs.usda.gov/Internet/FSE_MEDIA/fseprd563249.jpg",
//			"Located on the west face of the Sandia Mountains",
//			10378,
//			35.2197,
//			13.3,
//			106.4808,
//			7060,
//			"La Luz Trail"
//			);
//		$this->trail->insert($this->getPDO());
//	}

	/**
	 * Tests inserting a valid Trail and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		//create a new trail and save it into mySQL
		$trailId = generateUuidV4();
		$trail = new Trail(
			$trailId,
			$this->VALID_TRAIL_AVATAR_URL,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME,
		);
		$trail->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertEquals($pdoTrail->getTrailId(), $trailId);
		$this->assertEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL);
		$this->assertEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION);
		$this->assertEquals($pdoTrail->getTrailHigh(), $this->VALID_TRAIL_HIGH);
		$this->assertEquals($pdoTrail->getTrailLatitude(), $this->VALID_TRAIL_LATITUDE);
		$this->assertEquals($pdoTrail->getTrailLength(), $this->VALID_TRAIL_LENGTH);
		$this->assertEquals($pdoTrail->getTrailLongitude(), $this->VALID_TRAIL_LONGITUDE);
		$this->assertEquals($pdoTrail->getTrailLow(), $this->VALID_TRAIL_LOW);
		$this->assertEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME);
	}

	/**
	 * Test inserting a Trail, editing, and then updating it
	 **/
	public function testUpdateValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		//create a new trail and insert it into mySQL
		$trailId = generateUuidV4();
		$trail = new Trail(
			$trailId,
			$this->VALID_TRAIL_AVATAR_URL,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME,
			);
		$trail->insert($this->getPDO());
		//edit the profile and insert it into mysql
		$trail->setTrailAvatarUrl($this->VALID_TRAIL_AVATAR_URL_2);
		$trail->setTrailDescription($this->VALID_TRAIL_DESCRIPTION_2);
		$trail->setTrailName($this->VALID_TRAIL_NAME_2);
		$trail->update($this->getPDO());
		//grab the data from mySQL and enforce that the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertEquals($pdoTrail->getTrailId(), $trailId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL_2);
		$this->assertEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION_2);
		$this->assertEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME_2);
	}

	/**
	 * Tests creating a Trail and then deleting it
	 **/
	public function testDeleteValidTrail() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		$trailId = generateUuidV4();
		$trail = new Trail(
			$trailId,
			$this->VALID_TRAIL_AVATAR_URL,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME,
			);
		$trail->insert($this->getPDO());
		//delete the trail from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$trail->delete($this->getPDO());
		//grab data from mySQL and enforce that Trail does not exist
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertNull($pdoTrail);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("trail"));
	}

	/**
	 * Tests inserting a Trail and regrabbing it from mySQL
	 **/
	public function testGetValidTrailByTrailId() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		$trailId = generateUuidV4();
		$trail = new Trail(
			$trailId,
			$this->VALID_TRAIL_AVATAR_URL,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME
		);
		$trail->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertEquals($pdoTrail->getTrailId(), $trailId);
		$this->assertEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL);
		$this->assertEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL_2);
		$this->assertEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION);
		$this->assertEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION_2);
		$this->assertEquals($pdoTrail->getTrailHigh(), $this->VALID_TRAIL_HIGH);
		$this->assertEquals($pdoTrail->getTrailLatitude(), $this->VALID_TRAIL_LATITUDE);
		$this->assertEquals($pdoTrail->getTrailLength(), $this->VALID_TRAIL_LENGTH);
		$this->assertEquals($pdoTrail->getTrailLongitude(), $this->VALID_TRAIL_LONGITUDE);
		$this->assertEquals($pdoTrail->getTrailLow(), $this->VALID_TRAIL_LOW);
		$this->assertEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME);
		$this->assertEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME_2);
	}

	/**
	 * Tests grabbing a Trail that does not exist
	 **/
	public function testGetInvalidTrailByTrailId() : void {
		//grab trail id that exceeds maximum amount of characters
		$fakeTrailId = generateUuidV4();
		$trail = Trail::getTrailByTrailId($this->getPDO(), $fakeTrailId);
		$this->assertNull($trail);
	}

	/**
	 * Tests grabbing a Trail by trail name that does not exist
	 **/
	public function testGetInvalidTrailName() : void {
		//grab trail id that exceeds maximum amount of characters
		$fakeTrailName = "A Goofy Trail";
		$trail = Trail::getTrailByTrailName($this->getPDO(), $fakeTrailName);
		$this->assertNull($trail);
	}

	/**
	 * Tests grabbing all valid Trails
	 **/
	public function testGetAllValidTrails() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		//create a trail and insert it into mySQL
		$trailId = generateUuidV4();
		$trail = new Trail(
			$trailId,
			$this->VALID_TRAIL_AVATAR_URL,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME
			);
		$trail = insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Trail::getAllTrails($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("CapstoneTrails\\Abqtrails\\Trail", $results);
		//grab results from array and validate it
		$pdoTrail = $results[0];

		$this->assertEquals($pdoTrail->getTrailId(), $trailId);
		$this->assertEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL);
		$this->assertEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION);
		$this->assertEquals($pdoTrail->getTrailHigh(), $this->VALID_TRAIL_HIGH);
		$this->assertEquals($pdoTrail->getTrailLatitude(), $this->VALID_TRAIL_LATITUDE);
		$this->assertEquals($pdoTrail->getTrailLength(), $this->VALID_TRAIL_LENGTH);
		$this->assertEquals($pdoTrail->getTrailLongitude(), $this->VALID_TRAIL_LONGITUDE);
		$this->assertEquals($pdoTrail->getTrailLow(), $this->VALID_TRAIL_LOW);
		$this->assertEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME);
	}

}

