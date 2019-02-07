<?php

namespace abqtrails;
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
	 * valid profile id
	 * @var string $VALID_PROFILE_ID
	 */
	protected $VALID_PROFILE_ID = "nananananananana";
	/**
	 * valid profile activation
	 * @var string $VALID_PROFILE_ACTIVATION_TOKEN
	 */
	protected $VALID_PROFILE_ACTIVATION_TOKEN = "hahahahahahahahahahahahahahahaha";
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
	protected $VALID_PROFILE_HASH = "nanananananananananananananananananananananananananananananananananananananananananananananananaa";
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
}