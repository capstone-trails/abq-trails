<?php
namespace abqtrails;

use abqtrails\Photo\uuid\vendor;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the photo class
 *
 * This is a complete PHPUnit test of the photo class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see photo
 * @author Ronald Luna <rluna41@cnm.edu>
 **/
class photoTest extends abq-trailsTest {
	/**
	 * ProfileUser that created the photo; this is for foreign key relations
	 * @var ProfileUserId profileUserId
	 **/
	protected $profileUserId = null;


	/**
	 * valid profileUser Id to create the profileUserId object to own the test
	 * @var $VALID_ID
	 */
	protected $VALID_PROFILE USER_ID;

	/**
	 * content of the photo
	 * @var string $VALID_PHOTOURL
	 **/
	protected $VALID_PHOTOURL = "PHPUnit test passing";

	/**
	 * content of the updated photo
	 * @var string $VALID_PHOTOURL2
	 **/
	protected $VALID_PHOTOURL2 = "PHPUnit test still passing";

	/**
	 * timestamp of the photo; this starts as null and is assigned later
	 * @var \photoDateTime $VALID_PHOTODATETIME
	 **/
	protected $VALID_PHOTOURL = null;

	/**
	 * Valid timestamp to use as sunrisePhotoDateTime
	 */
	protected $VALID_SUNRISEDATETIME = null;

	/**
	 * Valid timestamp to use as sunsetPhotoDateTime
	 */
	protected $VALID_SUNSETDATETIME = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_ID = password_id($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Profile to own the test photo
		$this->profileUserId = new ProfileUserId(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profileUserId->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_PHOTODATETIME = new \photoDateTime();

		//format the sunrise date time to use for testing
		$this->VALID_SUNRISEDATETIME = new \photoDateTime();
		$this->VALID_SUNRISEDATETIME->sub(new \DateTimeInterval("P10D"));

		//format the sunset date time to use for testing
		$this->VALID_SUNSETDATETIME = new\photoDateTime();
		$this->VALID_SUNSETDATETIME->add(new \DateTmeInterval("P10D"));



	}

	/**
	 * test inserting a valid photo and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profileUserId->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = photo::getphotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoId(), $PhotoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}

	/**
	 * test inserting a photo, editing it, and then updating it
	 **/
	public function testUpdateValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$potoId = generateUuidV4();
		$photot = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// edit the photo and update it in mySQL
		$photo->setPhotoUrl($this->VALID_PHOTOURL2);
		$photo->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = photo::getphotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertEquals($pdophoto->getPhotoId(), $photoId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}


	/**
	 * test creating a photo and then deleting it
	 **/
	public function testDeleteValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// delete the photo from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$photo->delete($this->getPDO());

		// grab the data from mySQL and enforce the photo does not exist
		$pdoPhoto = photo::getPhotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertNull($pdoPhoto);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("photo"));
	}

	/**
	 * test inserting a photo and regrabbing it from mySQL
	 **/
	public function testGetValidPhotoByPhotoProfileUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = photo::getPhotoByPhotoProfileUserId($this->getPDO(), $photo->getPhotoProfileUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\abq-trails\\photo", $results);

		// grab the result from the array and validate it
		$pdoPhoto = $results[0];

		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileUSerId(), $this->profile->getProfileUSerId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}

	/**
	 * test grabbing a photo by photo content
	 **/
	public function testGetValidPhotoByPhotoUrl() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = photo::getPhotoByPhotoUrl($this->getPDO(), $photo->getPhotoUrl());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\abq-trails\\photo", $results);

		// grab the result from the array and validate it
		$pdoPhoto = $results[0];
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}

	/**
	 * test grabbing all photos
	 **/
	public function testGetAllValidPhotos() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = photo::getAllPhotos($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\abq-trails\\photo", $results);

		// grab the result from the array and validate it
		$pdoPhoto = $results[0];
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}
}