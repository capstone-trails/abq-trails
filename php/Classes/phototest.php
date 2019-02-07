<?php
namespace Edu\Cnm\DataDesign\Test;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secret.php");

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

/**
 * Abstract class containing universal and project specific mySQL parameters
 *
 * This class is designed to lay the foundation of the unit tests per project. It loads the all the database
 * parameters about the project so that table specific tests can share the parameters in on place. To use it:
 *
 * 1. Rename the class from photoTest to a project specific name (e.g., abq-trailsTest)
 * 2. Rename the namespace to be the same as in (1) (e.g., Edu\Cnm\abq-trails\Test)
 * 3. Modify photoTest::getDataSet() to include all the tables in your project.
 * 4. Modify photoTest::getConnection() to include the correct mySQL properties file.
 * 5. Have all table specific tests include this class.
 *
 * *NOTE*: Tables must be added in the order they were created in step (2).
 *
 * @author Ronald Luna <rluna41@cnm.edu>
 **/
abstract class photoTest extends TestCase {
	use TestCaseTrait;

	/**
	 * PHPUnit database connection interface
	 * @var Connection $connection
	 **/
	protected $connection = null;

	/**
	 * assembles the table from the schema and provides it to PHPUnit
	 *
	 * @return QueryDataSet assembled schema for PHPUnit
	 **/
	public final function getDataSet() : QueryDataSet {
		$dataset = new QueryDataSet($this->getConnection());

		// add all the tables for the project here
		// THESE TABLES *MUST* BE LISTED IN THE SAME ORDER THEY WERE CREATED!!!!
		$dataset->addTable("profileUser");
		$dataset->addTable("photo");
		// the second parameter is required because like is also a SQL keyword and is the only way PHPUnit can query the like table
		$dataset->addTable("photo", "SELECT photoProfileUserId, photoPhotoId, photoDateTime FROM `photo`");
		return($dataset);
	}

	/**
	 * templates the setUp method that runs before each test; this method expunges the database before each run
	 *
	 * @see https://phpunit.de/manual/current/en/fixtures.html#fixtures.more-setup-than-teardown PHPUnit Fixtures: setUp and tearDown
	 * @see https://github.com/sebastianbergmann/dbunit/issues/37 TRUNCATE fails on tables which have foreign key constraints
	 * @return Composite array containing delete and insert commands
	 **/
	public final function getSetUpOperation() : Composite {
		return new Composite([
			Factory::DELETE_ALL(),
			Factory::INSERT()
		]);
	}

	/**
	 * templates the tearDown method that runs after each test; this method expunges the database after each run
	 *
	 * @return Operation delete command for the database
	 **/
	public final function getTearDownOperation() : Operation {
		return(Factory::DELETE_ALL());
	}

	/**
	 * sets up the database connection and provides it to PHPUnit
	 *
	 * @see <https://phpunit.de/manual/current/en/database.html#database.configuration-of-a-phpunit-database-testcase>
	 * @return Connection PHPUnit database connection interface
	 **/
	public final function getConnection() : Connection {
		// if the connection hasn't been established, create it
		if($this->connection === null) {
			// connect to mySQL and provide the interface to PHPUnit


			$secrets =  new Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
			$pdo = $secrets->getPdoObject();
			$this->connection = $this->createDefaultDBConnection($pdo, $secrets->getDatabase());
		}
		return($this->connection);
	}

	/**
	 * returns the actual PDO object; this is a convenience method
	 *
	 * @return \PDO active PDO object
	 **/
	public final function getPDO() {
		return($this->getConnection()->getConnection());
	}
}

<?php
namespace Edu\Cnm\abq-trails\Test;

use Edu\Cnm\abq-trails\{ProfileUser, Photo};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the photo class
 *
 * This is a complete PHPUnit test of the photo class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see photo
 * @author Ronald Luna <rluna41@cnm.edu>
 **/
class TweetTest extends abq-trailsTest {
	/**
	 * ProfileUser that created the photo; this is for foreign key relations
	 * @var ProfileUserId profileUserId
	 **/
	protected $profileUserId = null;


	/**
	 * valid profileUser Id to create the profileUserId object to own the test
	 * @var $VALID_ID
	 */
	protected $VALID_PROFILE USER_ID;

	/**
	 * content of the photo
	 * @var string $VALID_PHOTOURL
	 **/
	protected $VALID_PHOTOURL = "PHPUnit test passing";

	/**
	 * content of the updated photo
	 * @var string $VALID_PHOTOURL2
	 **/
	protected $VALID_PHOTOURL2 = "PHPUnit test still passing";

	/**
	 * timestamp of the photo; this starts as null and is assigned later
	 * @var \photoDateTime $VALID_PHOTODATETIME
	 **/
	protected $VALID_PHOTOURL = null;

	/**
	 * Valid timestamp to use as sunrisePhotoDateTime
	 */
	protected $VALID_SUNRISEDATETIME = null;

	/**
	 * Valid timestamp to use as sunsetPhotoDateTime
	 */
	protected $VALID_SUNSETDATETIME = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_ID = password_id($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Profile to own the test Tweet
		$this->profileUserId = new ProfileUserId(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profileUserId->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_PHOTODATETIME = new \photoDateTime();

		//format the sunrise date time to use for testing
		$this->VALID_SUNRISEDATETIME = new \photoDateTime();
		$this->VALID_SUNRISEDATETIME->sub(new \DateTimeInterval("P10D"));

		//format the sunset date time to use for testing
		$this->VALID_SUNSETDATETIME = new\photoDateTime();
		$this->VALID_SUNSETDATETIME->add(new \DateTmeInterval("P10D"));



	}

	/**
	 * test inserting a valid photo and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$photoId = generateUuidV4();
		$photo = new photo($photoId, $this->profileUserId->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPhoto = photo::getphotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoId(), $PhotoId);
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}

	/**
	 * test inserting a photo, editing it, and then updating it
	 **/
	public function testUpdateValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new photo and insert to into mySQL
		$potoId = generateUuidV4();
		$photot = new photo($photoId, $this->profile->getProfileUserId(), $this->VALID_PHOTOURL, $this->VALID_PHOTODATETIME);
		$photo->insert($this->getPDO());

		// edit the Tweet and update it in mySQL
		$photo->setPhotoUrl($this->VALID_PHOTOURL2);
		$photo->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTweet = photo::getphotoByPhotoId($this->getPDO(), $photo->getPhotoId());
		$this->assertEquals($pdophoto->getPhotoId(), $photoId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("photo"));
		$this->assertEquals($pdoPhoto->getPhotoProfileUserId(), $this->profile->getProfileUserId());
		$this->assertEquals($pdoPhoto->getPhotoUrl(), $this->VALID_PHOTOURL2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPhoto->getPhotoDateTime()->getTimestamp(), $this->VALID_PHOTODATETIME->getTimestamp());
	}


	/**
	 * test creating a photo and then deleting it
	 **/
	public function testDeleteValidPhoto() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("photo");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// delete the Tweet from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$tweet->delete($this->getPDO());

		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoTweet = Tweet::getTweetByTweetId($this->getPDO(), $tweet->getTweetId());
		$this->assertNull($pdoTweet);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("tweet"));
	}

	/**
	 * test inserting a Tweet and regrabbing it from mySQL
	 **/
	public function testGetValidTweetByTweetProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetProfileId($this->getPDO(), $tweet->getTweetProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];

		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}

	/**
	 * test grabbing a Tweet by tweet content
	 **/
	public function testGetValidTweetByTweetContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetContent($this->getPDO(), $tweet->getTweetContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}

	/**
	 * test grabbing all Tweets
	 **/
	public function testGetAllValidTweets() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getAllTweets($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
}