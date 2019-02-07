<?php
namespace abqtrails;

use \abqtrails\Tag;

//grab the class under scrutiny
require_once("autoload.php");

//grab the uuid generator
require_once("../../vendor/autoload.php");

/**
 * Full PHPUnit for the Tag class
 *
 * This is a complete PHPUnit test of the tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tag
 * @author Robert Dominguez
 **/
class TagTest extends  AbqTrailsTest {
	/**
	 * name of the Tag
	 * @var string $VALID_TAGNAME
	 **/
	protected $VALID_TAGNAME = "Gorgeous View";

	/**
	 * name of the updated Tag
	 * @var string $VALID_TAGNAME
	 **/
	protected $VALID_TAGNAME2 = "Wheelchair Friendly";


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {
		//run the default setUp() method first
		parent::setUp();
		$password = "ab"
	}
}
