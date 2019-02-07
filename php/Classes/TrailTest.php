<?php
namespace abqtrails;

use abqtrails\Trail;
use abqtrails\ValidateUuid;
use abqtrails\ValidateDate;

//grab the class or trait in question
require_once("autoload.php");

//grab the uuid generator
require_once("../../vendor/autoload.php");

/**
 * Full PHPUnit test for the Trail class
 *
 * This is a complete PHPUnit test of the Trail class. It is complete because *ALL* mySQL/PDO enabled methods are tested
 * for both invalid and valid inputs.
 *
 * @see \abqtrails\Trail
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
	 * test inserting a valid Trail and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");
		$trailId = generateUuidV4();
		$trail = new Trail($trailId, $VALID_TRAIL_AVATAR_URL, $VALID_TRAIL_AVATAR_URL_2, $VALID_TRAIL_DESCRIPTION, $VALID_TRAIL_DESCRIPTION_2, $VALID_TRAIL_HIGH, $VALID_TRAIL_LATITUDE, $VALID_TRAIL_LENGTH, $VALID_TRAIL_LONGITUDE, $VALID_TRAIL_LOW, $VALID_TRAIL_NAME, $VALID_TRAIL_NAME_2);
		$trail->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailId($this->getPDO(), $trail->getTrailId());
		$this->assertsEquals($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertsEquals($pdoTrail->getTrailId(), $trailId);
	}











}