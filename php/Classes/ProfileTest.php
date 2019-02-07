<?php

namespace abqtrails;

use \abqtrails\Trail;

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
	protected $VALID_PROFILE_ACTIVATION_TOKEN = "nanananananananananananananananananananananananananananananananananananananananananananananananaa";
/**
 * valid profile avatar url
 * @var string $VALID_PROFILE_AVATAR_URL
 */
	protected $VALID_PROFILE_AVATAR_URL ="";
}