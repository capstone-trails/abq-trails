<?php
namespace abqtrails;

use \abqtrails\Trail;

//grab the class in question
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
	 * valid trail id to use
	 * @var string $VALID_TRAIL_ID
	 **/
	protected $VALID_TRAIL_ID = "nananananananana";
	/**
	 * valid trail avatar url to use
	 * @var string $VALID_TRAIL_AVATAR_URL
	 **/
	protected $VALID_TRAIL_AVATAR_URL = "https://picture.com/00001/";
	/**
	 * valid trail description to use
	 * @var string $VALID_TRAIL_DESCRIPTION
	 **/
	protected $VALID_TRAIL_DESCRIPTION = "Located on the west face of the Sandia Mountains";
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
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {
		//run the default setUp() method first
		parent::setUp();

	}











}