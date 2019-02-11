<?php
namespace Abqtrails;

//our autoloader
use phpDocumentor\Reflection\DocBlock\Tags\Generic;

require_once("autoload.php");
//composer autoloader
require_once("../../vendor/autoload.php");

/**
 * Full PHPUnit test for the Trail class
 *
 * This is a complete PHPUnit test of the Trail class. It is complete because *ALL* mySQL/PDO enabled methods are tested
 * for both invalid and valid inputs.
 *
 * @see \Abqtrails\Trail
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
	protected $VALID_TRAIL_HIGH = "10,378";
	/**
	 * valid trail latitude coordinate
	 * @var string $VALID_TRAIL_LATITUDE
	 **/
	protected $VALID_TRAIL_LATITUDE = "35.2197 N";
	/**
	 * valid trail length
	 * @var string $VALID_TRAIL_LENGTH
	 **/
	protected $VALID_TRAIL_LENGTH = "13.3";
	/**
	 * valid trail longitude coordinate
	 * @var string $VALID_TRAIL_LONGITUDE
	 **/
	protected $VALID_TRAIL_LONGITUDE = "106.4808 W";
	/**
	 * valid trail lowest elevation in feet
	 * @var string $VALID_TRAIL_LOW
	 **/
	protected $VALID_TRAIL_LOW = "7060";
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
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "mysql12345";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Trail and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		//create a new trail and save it into mySQL
		$trailId = generateUuidV4();
		$trail = new Trail(
			$trailId,
			$this->VALID_TRAIL_AVATAR_URL,
			$this->VALID_TRAIL_AVATAR_URL_2,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_DESCRIPTION_2,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME,
			$this->VALID_TRAIL_NAME_2);
		$trail->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertsEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertsEquals($pdoTrail->getTrailId(), $trailId);
		$this->assertsEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL);
		$this->assertsEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION);
		$this->assertsEquals($pdoTrail->getTrailHigh(), $this->VALID_TRAIL_HIGH);
		$this->assertsEquals($pdoTrail->getTrailLatitude(), $this->VALID_TRAIL_LATITUDE);
		$this->assertsEquals($pdoTrail->getTrailLength(), $this->VALID_TRAIL_LENGTH);
		$this->assertsEquals($pdoTrail->getTrailLongitude(), $this->VALID_TRAIL_LONGITUDE);
		$this->assertsEquals($pdoTrail->getTrailLow(), $this->VALID_TRAIL_LOW);
		$this->assertsEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME);
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
			$this->VALID_TRAIL_AVATAR_URL_2,
			$this->VALID_TRAIL_DESCRIPTION,
			$this->VALID_TRAIL_DESCRIPTION_2,
			$this->VALID_TRAIL_HIGH,
			$this->VALID_TRAIL_LATITUDE,
			$this->VALID_TRAIL_LENGTH,
			$this->VALID_TRAIL_LONGITUDE,
			$this->VALID_TRAIL_LOW,
			$this->VALID_TRAIL_NAME,
			$this->VALID_TRAIL_NAME_2);
		$trail->insert($this->getPDO());
		//edit the profile and insert it into mysql
		$trail->setTrailAvatarUrl($this->VALID_TRAIL_AVATAR_URL_2);
		$trail->setTrailDescription($this->VALID_TRAIL_DESCRIPTION_2);
		$trail->setTrailName($this->VALID_TRAIL_NAME_2);
		$trail->update($this->getPDO());
		//grab the data from mySQL and enforce that the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertsEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertsEquals($pdoTrail->getTrailId(), $trailId);
		$this->assertsEquals($pdoTrail->getTrailAvatarUrl(), $this->VALID_TRAIL_AVATAR_URL);
		$this->assertsEquals($pdoTrail->getTrailDescription(), $this->VALID_TRAIL_DESCRIPTION);
		$this->assertsEquals($pdoTrail->getTrailHigh(), $this->VALID_TRAIL_HIGH);
		$this->assertsEquals($pdoTrail->getTrailLatitude(), $this->VALID_TRAIL_LATITUDE);
		$this->assertsEquals($pdoTrail->getTrailLength(), $this->VALID_TRAIL_LENGTH);
		$this->assertsEquals($pdoTrail->getTrailLongitude(), $this->VALID_TRAIL_LONGITUDE);
		$this->assertsEquals($pdoTrail->getTrailLow(), $this->VALID_TRAIL_LOW);
		$this->assertsEquals($pdoTrail->getTrailName(), $this->VALID_TRAIL_NAME);
	}





}