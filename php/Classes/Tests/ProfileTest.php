<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Profile;

//our autoloader
require_once(dirname(__DIR__, 1) . "/autoload.php");

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Unit Tests for Profile Class
 *
 * @see \CapstoneTrails\AbqTrails\Profile
 * @author Cassandra Romero <cromero278@cnm.edu>
 */
class ProfileTest extends AbqTrailsTest {
	/**
	 * valid profile activation
	 * @var string $VALID_PROFILE_ACTIVATION_TOKEN
	 */
	protected $VALID_PROFILE_ACTIVATION_TOKEN;
	/**
	 * valid profile avatar url
	 * @var string $VALID_PROFILE_AVATAR_URL
	 */
	protected $VALID_PROFILE_AVATAR_URL = "https://www.testavatarurlabqtrails.com";
	/**
	 * updated profile avatar url
	 * @var string $VALID_PROFILE_AVATAR_URL_2
	 */
	protected $VALID_PROFILE_AVATAR_URL_2 = "www.abcdef123.com";
	/**
	 * valid profile email address
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "abc3cdcom@test.com";
	/**
	 * updated profile email
	 * @var string $VALID_PROFILE_EMAIL_2
	 */
	protected $VALID_PROFILE_EMAIL_2 = "abc4@test.com";
	/**
	 * valid profile first name
	 * @var string $VALID_PROFILE_FIRST_NAME
	 */
	protected $VALID_PROFILE_FIRST_NAME = "Jon";
	/**
	 * updated first name
	 * @var string $VALID_PROFILE_FIRST_NAME_2
	 */
	protected $VALID_PROFILE_FIRST_NAME_2 = "Jane";
	/**
	 * valid profile hash
	 * @var string $VALID_PROFILE_HASH
	 */
	protected $VALID_PROFILE_HASH = "mamamamamamamamamamamamamamamama";
	/**
	 * valid profile last name
	 * @var string $VALID_PROFILE_LAST_NAME
	 */
	protected $VALID_PROFILE_LAST_NAME = "Smiths";
	/*
	 * updated profile last name
	 * @var string $VALID_PROFILE_LAST_NAME_2
	 */
	protected $VALID_PROFILE_LAST_NAME_2 = "Doe";
	/**
	 * valid profile username
	 * @var string $VALID_PROFILE_USERNAME
	 */
	protected $VALID_PROFILE_USERNAME = "nam1";
	/*
	 * updated profile username
	 * @var string $VALID_PROFILE_USERNAME_2
	 */
	protected $VALID_PROFILE_USERNAME_2 = "name3";
	/**
	 * setup to create hash
	 */
	public final function setUp() : void {
		//count the number of rows
		parent::setUp();
		$password = "coffee12345";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILE_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}
	/*
	 * Tests inserting a Profile into mySQL database
	 */
	public function testInsertValidProfile() : void {
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getprofileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
	}
	/**
	 * public inserting and updated a profile
	 */
	public function testUpdateValidProfile(){
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$profile->setProfileAvatarUrl($this->VALID_PROFILE_AVATAR_URL_2);
		$profile->setProfileEmail($this->VALID_PROFILE_EMAIL_2);
		$profile->setProfileFirstName($this->VALID_PROFILE_FIRST_NAME_2);
		$profile->setProfileLastName($this->VALID_PROFILE_LAST_NAME_2);
		$profile->setProfileUsername($this->VALID_PROFILE_USERNAME_2);
		$profile->update($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL_2);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL_2);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME_2);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME_2);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME_2);
	}
	/**
	 * public function creating and then deleting a profile
	 */
	public function testDeleteValidProfile() : void {
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));

	}
	/*
	 * public function that gets a profile by the activation token
	 */
	public function testGetProfileByActivationToken() : void {
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getprofileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
	}
	/*
	 * public function that gets profile by an invalid activation token
	 */
	public function testGetInvalidProfileActivationToken() : void {
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "1111111111111111");
		$this->assertNull($profile);
	}
	/*
 	* public function that gets profile by profile email
 	*/
	public function testGetProfileByProfileEmail() {
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getprofileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
	}
	/*
	 * public function that gets a profile by an email that does not exist
	 */
	public function testGetInvalidProfileByEmail() : void {
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "invalid@email.co");
		$this->assertNull($profile);
	}
	/**
	 * public function that gets profile by the username
	 */
	public function testGetProfileByProfileUsername() {
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileUsername($this->getPDO(), $profile->getProfileUsername());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getprofileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
	}
	/*
	 * public function that gets a profile that does not exist
	 */
	public function testGetInvalidProfileByUsername() : void {
		$profile = Profile::getProfileByProfileUsername($this->getPDO(), "abcdefg");
		$this->assertNull($profile);
	}
}
