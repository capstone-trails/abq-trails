<?php
namespace abqtrails;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

//grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secret.php");

require_once ("../../vendor/autoload.php");

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








}