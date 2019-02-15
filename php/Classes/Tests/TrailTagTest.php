<?php
namespace CapstoneTrails\AbqTrails\Tests;

use CapstoneTrails\AbqTrails\Profile;
use CapstoneTrails\AbqTrails\Trail;
use CapstoneTrails\AbqTrails\TrailTag;
use CapstoneTrails\AbqTrails\Tag;

require_once(dirname(__DIR__, 1) . "/autoload.php");

require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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
		$this->trail = new Trail(generateUuidV4(), "www.faketrail.com/photo", "This trail is a fine trail", 1234, 35.0792, 5.2, 106.4847, 1254, "Copper Canyon");
		$this->trail->insert($this->getPDO());

		//create and insert new tag from trail tag
		$this->tag = new Tag(generateUuidV4(), "Dog Friendly");
		$this->tag->insert($this->getPDO());
		}
	/**
	 * function that inserts a valid trail tag
	 */
		public function testInsertValidTrailTag (): void {
			//count the number of rows
			$numRows = $this->getConnection()->getRowCount("trailTag");

			//create new trail tag and insert into mySQL
			$trailTag = new TrailTag($this->tag->getTagId(), $this->trail->getTrailId(), $this->profile->getProfileId());
			$trailTag->insert($this->getPDO());
			var_dump($trailTag);
			//grab data from mySQL and enforce the fields match our expectations
			$results = TrailTag::getTrailTagByTrailTagTagIdAndTrailTagTrailId($this->getPDO(), $this->tag->getTagId(), $this->trail->getTrailId());
			var_dump($results);
			$pdoTrailTag = $results[0];
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("trailTag"));
			$this->assertEquals($pdoTrailTag->getTrailTagTagId(), $this->tag->getTagId());
			$this->assertEquals($pdoTrailTag->getTrailTagTrailId(), $this->trail->getTrailId());
			$this->assertEquals($pdoTrailTag->getTrailTagProfileId(), $this->profile->getProfileId());
		}
	}