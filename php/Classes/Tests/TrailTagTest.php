<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Profile;
use CapstoneTrails\AbqTrails\TrailTag;
use CapstoneTrails\AbqTrails\Tag;

require_once(dirname(__DIR__, 1) . "/autoload.php");

/**
 * @see TrailTag
 *
*/

class TrailTagTest extends  AbqTrailsTest {
	/**
	 * Tag from tag/trail tag relationship, primary key
	 * @var Tag $tag
	 */
	protected $tag = null;
	/**
	 * Trail from trail/trail tag relationship, primary key
	 */
	protected $trail = null;
	/**
	 * Profile from profile/trail tag relationship, foreign key
	 * @var Profile $profile
	 */
	protected $profile = null;

	protected $VALID_HASH;

	protected $VALID_ACTIVATION;
	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
}