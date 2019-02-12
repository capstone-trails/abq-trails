<?php
namespace CapstoneTrails\AbqTrails\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

//grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secrets.php");

require_once(dirname(__DIR__) . "/../../vendor/autoload.php");


/**
 * Abstract class contain universal and project specific mySQL parameters
 *
 * This class is design to lay the foundation of the unit tests per project. It loads all the database parameters about the
 * project so that table specific tests can share the parameters in one place. To use it:
 *
 * 1. Rename the class from AbqTrailsTest to a project specific name (e.g. ProjectNameTest)
 * 2. Rename the namespace to be the same as (1)
 * 3. Modify AbqTrailsTest::getDataSet() to include all the tables in you project
 * 4. Modify AbqTrailsTest::getConnection() to include the correct mySQL properties file
 * 5. Have all table specific tests include this class
 *
 * *NOTE*: Tables must be added in the order they were created in step (2)
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @updated (for project) Scott Wells <swells19@cnm.edu>
 **/
abstract class AbqTrailsTest extends TestCase {
	use TestCaseTrait;

	/**
	 * PHPUnit database connection interface
	 * @var Connection $connection
	 **/
	private $connection = null;

	/**
	 * assembles the table from the schema and provides it to PHPUnit
	 *
	 * @return QueryDataSet assembled schema for PHPUnit
	 **/
	public final function getDataSet() : QueryDataSet {
		$dataset = new QueryDataSet($this->getConnection());

		//add all the tables for the project her
		//THESE TABLES *MUST* BE LISTED IN THE SAME ORDER THEY WERE CREATED!!!
		$dataset->addTable("profile");
		$dataset->addTable("trail");
		$dataset->addTable("photo");
		$dataset->addTable("rating");
		$dataset->addTable("tag");
		$dataset->addTable("trailTag");
		return($dataset);
	}

	/**
	 * templates the setUp method that runs before each Tests; this method expunges the database before each run
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
	 * templates the tearDown method that runs after each Tests; this method expunges the database after each run
	 *
	 * @return Operation delete command for the database
	 **/
	public final function getTearDownOperation() : Operation {
		return(Factor::DELETE_ALL());
	}

	/**
	 * sets up the database connection and provides it to PHPUnit
	 *
	 * @see https://phpunit.de/manual/current/en/database.html#database.configuration-of-a-phpunit-database-testcase
	 * @return Connection PHPUnit database connection interface
	 **/
	public final function getConnection() : Connection {
		//if the connection hasn't been established, create it
		if($this->connection === null) {
			//connect to mySQL and provide the interface to PHPUnit

			$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
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