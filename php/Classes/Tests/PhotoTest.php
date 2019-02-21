<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Photo;
use CapstoneTrails\AbqTrails\Profile;
use CapstoneTrails\AbqTrails\Trail;

//our autoloader
require_once(dirname(__DIR__, 1) . "/autoload.php");

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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
	 * Profile that created the photo; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;
	/**
	 * Trail photo is attached to
	 */
	protected $trail = null;
	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	/**
	 * content of the Photo
	 * @var string $VALID_PHOTO
	 **/
	/**
	 * @var /DateTime photo was created, set to null and assigned later
	 */
	protected $VALID_PHOTO_DATE_TIME = null;

	protected $VALID_PHOTO_URL = "https://media-cdn.tripadvisor.com/media/photo-s/07/52/66/47/new-mexico-rails-to-trails.jpg";

	protected $VALID_PHOTO_URL_2 = "https://media-cdn.tripadvisor.com/media/photo-s/09/3a/b7/5b/turquoise-trail.jpg";

	protected $VALID_PROFILE_HASH;

	protected $VALID_PROFILE_ACTIVATION;

	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		parent::setUp();
		$password = "heythere123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILE_ACTIVATION = bin2hex(random_bytes(16));
		// create and insert a Profile to own the Tests photo
		$this->profile = new Profile(generateUuidV4(), $this->VALID_PROFILE_ACTIVATION, "@handle", "https://email@email.com", "Chimp", $this->VALID_PROFILE_HASH, "Shrimp", "namename");
		$this->profile->insert($this->getPDO());
		//create and insert trail from trail tag
		$this->trail = new Trail(generateUuidV4(), "www.faketrail.com/photo", "This trail is a fine trail", 1234, 35.0792, 5.2, 106.4847, 1254, "Copper Canyon");
		$this->trail->insert($this->getPDO());
		// calculate the date (just use the time the unit Tests was setup...)
		$this->VALID_PHOTO_DATE_TIME = new \DateTime();
	}
	/**
	 * Tests inserting a valid photo and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPhoto(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");
		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new Photo($photoId, $this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_PHOTO_DATE_TIME, $this->VALID_PHOTO_URL);
		$photo->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = Photo::getPhotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPhoto->getPhotoTrailId(), $this->trail->getTrailId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTO_DATE_TIME->getTimestamp());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTO_URL);
	}

	/**
	 * Tests inserting a photo, editing it, and then updating it
	 **/
	public function testUpdateValidPhoto(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new Photo($photoId, $this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_PHOTO_DATE_TIME, $this->VALID_PHOTO_URL);
		$photo->insert($this->getPDO());
		// edit the photo and update it in mySQL
		$photo->setPhotoUrl($this->VALID_PHOTO_URL_2);
		$photo->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = Photo::getPhotoByPhotoId($this->getPDO(), $photoId->getPhotoId());
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPhoto->getPhotoTrailId(), $this->trail->getTrailId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTO_DATE_TIME->getTimestamp());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTO_URL_2);
	}

	/**
	 * Tests creating a photo and then deleting it
	 **/
	public function testDeleteValidPhoto(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new Photo($photoId, $this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_PHOTO_DATE_TIME, $this->VALID_PHOTO_URL);
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
	public function testGetValidPhotoByPhotoProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");
		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new Photo($photoId, $this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_PHOTO_DATE_TIME, $this->VALID_PHOTO_URL);
		$photo->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Photo::getPhotoByPhotoProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("CapstoneTrails\\AbqTrails\\Photo", $results);
		// grab the result from the array and validate it
		$pdoPhoto = $results[0];
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPhoto->getPhotoTrailId(), $this->trail->getTrailId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTO_DATE_TIME->getTimestamp());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTO_URL);
	}

	/**
	 * Tests inserting a photo and regrabbing it from mySQL
	 **/
	public function testGetValidPhotoByPhotoTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");
		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new Photo($photoId, $this->profile->getProfileId(), $this->trail->getTrailId(), $this->VALID_PHOTO_DATE_TIME, $this->VALID_PHOTO_URL);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Photo::getPhotoByPhotoTrailId($this->getPDO(), $this->trail->getTrailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("CapstoneTrails\\AbqTrails\\Photo", $results);
		// grab the result from the array and validate it
		$pdoPhoto = $results[0];
		$this->assertEquals($pdoPhoto->getPhotoId(), $photoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPhoto->getPhotoTrailId(), $this->trail->getTrailId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTO_DATE_TIME->getTimestamp());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTO_URL);
	}
}