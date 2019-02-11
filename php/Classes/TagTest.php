<?php
namespace CapstoneTrails\AbqTrails;

//use \abqtrails\Tag;

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
	protected $VALID_TAGNAME_1 = "Gorgeous View";

	/**
	 * name of the updated Tag
	 * @var string $VALID_TAGNAME
	 **/
	protected $VALID_TAGNAME_2 = "Wheelchair Friendly";


	/**
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public final function testInsertValidTag() : void {
		// counts the number of rows and saves it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->VALID_TAGNAME_1, $this->VALID_TAGNAME_2);
		$tag->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our experience
		$pdoTag = Tag::getTagByTagId($this->getPDO(),$tag->getTagId());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagName1(), $this->VALID_TAGNAME_1);
		$this->assertEquals($pdoTag->getTagName2(), $this->VALID_TAGNAME_2 );
	}
	/**
	 * test inserting a Tag, editing it, and then updating it
	 **/
	public function testUpdateValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		// create a new Tag and insert into mySQL
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->VALID_TAGNAME_1, $this->VALID_TAGNAME_2);
		$tag-> insert($this->getPDO());
		// edit the Tag and update it in mySQL
		$tag->setTagName1($this->VALID_TAGNAME_1_2);
		$tag->setTagName2($this->VALID_TAGNAME_2_2);
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagName1(), $this->VALID_TAGNAME_1_2);
		$this->assertEquals($pdoTag->getTagName2(), $this->VALID_TAGNAME_2_2);
	}
}
