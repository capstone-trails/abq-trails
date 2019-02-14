<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Profile;
use CapstoneTrails\AbqTrails\Trail;
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
	public final function setUp(): void {
		parent::setUp();
		$password = "heythere123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert a profile
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, "www.blahblah.com/12222", "myname@man.com", "Matt", $this->VALID_HASH, "Damon", "mattDamon");
		$this->profile->insert($this->getPDO());

		//create and insert trail from trail tag
		$this->trail = new Trail(generateUuidV4(), "www.faketrail.com/photo", "This trail is a fine trail", "1234", "35.0792", "5.2", "106.4847", "`1254`", "Copper Canyon");
		$this->trail->insert($this->getPDO());d
		}
	}