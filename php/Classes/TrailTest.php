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
	 * Trail that will be put into database
	 * @var $trail trail
	 **/
	private $trail = null;

	/**
	 * Url that will be put into the database
	 * @var $avatarUrl trail avatar url
	 **/
	private $avatarUrl = null;

	/**
	 * Description that will be put into the database
	 * @var $trailDescription trail description
	 **/
	private $trailDescription = null;

	/**
	 * High trail elevation that will be put into the database
	 * @var $trailHigh trail highest point in feet
	 **/
	private $trailHigh = null;

	/**
	 * Latitude trail coordinate that will be put into the database
	 * @var $trailLatitude trail latitude data
	 **/
	private $trailLatitude = null;

	/**
	 * Length trail total length in feet that will be put into the database
	 * @var $trailLength
	 **/
	private $trailLength = null;

	/**
	 * Longitude trail coordinate that will be put into the database
	 * @var $trailLongitude trail longitude data
	 **/
	private $trailLongitude = null;














}