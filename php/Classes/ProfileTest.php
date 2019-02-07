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
 * valid profile email address
 * @var string $VALID_PROFILE_EMAIL
 */
	protected $VALID_PROFILE_EMAIL = "newusertest@abqtrails.com";
/**
 * valid profile hash
 * @var string $VALID_PROFILE_HASH
 */
	protected $VALID_PROFILE_HASH = "nanananananananananananananananananananananananananananananananananananananananananananananananaa";

}