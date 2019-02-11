<?php
namespace CapstoneTrails\AbqTrails;

require_once(dirname(__DIR__, 1) . "/autoload.php");
/**
 * Full PHPUnit Tests for the photo class
 *
 * This is a complete PHPUnit Tests of the photo class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Photo
 * @author Ronald Luna <rluna41@cnm.edu>
 **/
class PhotoTest extends AbqTrailsTest {
	/**
	 * ProfileUser that created the photo; this is for foreign key relations
	 * @var Profile profileUserId
	 **/
	protected $profileUserId = null;
	/**
	 * content of the photo
	 * @var string $VALID_PHOTOURL
	 **/
	protected $VALID_PHOTO_URL = "PHPUnit Tests passing";

	/**
	 * content of the updated photo
	 * @var string $VALID_PHOTOURL2
	 **/
	protected $VALID_PHOTOURL2 = "PHPUnit Tests still passing";

	/**
	 * timestamp of the photo; this starts as null and is assigned later
	 * @var \photoDateTime $VALID_PHOTODATETIME
	 **/
	protected $VALID_PHOTOURL = null;

	/**
	 * Valid timestamp to use as sunrisePhotoDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetPhotoDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each Tests
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_ID = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Profile to own the Tests photo
		$this->profile = new ProfileUserId(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "Tests@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit Tests was setup...)
		$this->VALID_PHOTODATETIME = new \DateTime();

		//format the sunrise date time to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date time to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));



	}

	/**
	 * Tests inserting a valid photo and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new Photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = photo::getPhotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATE->getTimestamp());
	}

	/**
	 * Tests inserting a photo, editing it, and then updating it
	 **/
	public function testUpdateValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photoId = new photo($photoId , $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATE);
		$photoId->insert($this->getPDO());

		// edit the photo and update it in mySQL
		$photoId->setPhotoUrl($this->VALID_PHOTOURL2);
		$photoId->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = photo::getphotoByPhotoId($this->getPDO(), $photoId->getPhotoId());
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATE->getTimestamp());
	}


	/**
	 * Tests creating a photo and then deleting it
	 **/
	public function testDeleteValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATE);
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
	 * Tests inserting a photo and regrabbing it from mySQL
	 **/
	public function testGetValidPhotoByPhotoProfileUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATE);
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
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATE->getTimestamp());
	}

	/**
	 * Tests grabbing a photo by photo content
	 **/
	public function testGetValidPhotoByPhotoUrl() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATE);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = photo::getPhotoByPhotoUrl($this->getPDO(), $photo->getPhotoUrl());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the Tests
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
	 * Tests grabbing all photos
	 **/
	public function testGetAllValidPhotos() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATE);
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
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATE->getTimestamp());
	}
}
