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
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public final function testInsertValidTag() : void {
		// counts the number of rows and saves it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		$tagId = generateUuidV4();
		$tag = new Tag($tag, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our experience
		$pdoTag = Tag::getTagByTagId($this->getPDO(),$tag->getTagId());
		$this->assertEquals(numRows +1)
	}
}
