<?php

namespace Abqtrails;

use \abqtrails\Profile;

require_once("autoload.php");

require_once("../../vendor/autoload.php");

/**
 * Unit test for Profile Class
 *
 * @see \abqtrails\Profile
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
	protected $VALID_PROFILE_AVATAR_URL = "https://www.testavatarurlabqtrails.co";
	/**
	 * updated profile avatar url
	 * @var string $VALID_PROFILE_AVATAR_URL_2
	 */
	protected $VALID_PROFILE_AVATAR_URL_2 = "https://www.igotanewavatar.com/1234";
	/**
	 * valid profile email address
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "newusertest@testtest.com";
	/**
	 * updated profile email
	 * @var string $VALID_PROFILE_EMAIL_2
	 */
	protected $VALID_PROFILE_EMAIL_2 = "sameusernewemail@test.com";
	/**
	 * valid profile first name
	 * @var string $VALID_PROFILE_FIRST_NAME
	 */
	protected $VALID_PROFILE_FIRST_NAME = "Nancy";
	/**
	 * updated first name
	 * @var string $VALID_PROFILE_FIRST_NAME_2
	 */
	protected $VALID_PROFILE_FIRST_NAME_2 = "Fancy";
	/**
	 * valid profile hash
	 * @var string $VALID_PROFILE_HASH
	 */
	protected $VALID_PROFILE_HASH;
	/**
	 * valid profile last name
	 * @var string $VALID_PROFILE_LAST_NAME
	 */
	protected $VALID_PROFILE_LAST_NAME = "Reagan";
	/*
	 * updated profile last name
	 * @var string $VALID_PROFILE_LAST_NAME_2
	 */
	protected $VALID_PROFILE_LAST_NAME_2 = "Solo";
	/**
	 * valid profile username
	 * @var string $VALID_PROFILE_USERNAME
	 */
	protected $VALID_PROFILE_USERNAME = "thefirstlady123";
	/*
	 * updated profile username
	 * @var string $VALID_PROFILE_USERNAME_2
	 */
	protected $VALID_PROFILE_USERNAME_2 = "notthefirstlady999";

	/**
	 * setup to create hash
	 */
	public final function setUp() : void {
		parent::setUp();

		$password = "coffee12345";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 97]);
		$this->VALID_PROFILE_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}
	/*
	 * test inserting a Profile into mySQL database
	 */
	public function testInsertValidProfile() : void {
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new \abqtrails\Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_AVATAR_URL,
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

}