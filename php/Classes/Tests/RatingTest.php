<?php
namespace CapstoneTrails\AbqTrails\Tests;

//use \abqtrails\Tag;

//grab the class under scrutiny
require_once(dirname(__DIR__, 1) . "/autoload.php");

/**
 * Full PHPUnit for the Rating class
 *
 * This is a complete PHPUnit Tests of the Rating class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Rating
 * @author Robert Dominguez
 **/
class RatingTest extends AbqTrailsTest {
	/**
	 * valid rating about to use
	 * @var string $VALID_VALUE
	 **/
	protected $VALID_VALUE = "Dog-Friendly";
	/**
	 * content of the updated Rating
	 * @var string $VALID_VALUE_2
	 **/
	protected $VALID_VALUE_2 = "Wheelchair accessible";
	/**
	 * valid rating Difficulty
	 * @var string $VALID_DIFFICULTY
	 **/
	protected $VALID_DIFFICULTY = "Medium";
	/**
	 * content of the updated difficulty
	 * @var string $VALID_DIFFICULTY_2
	 **/
	protected $VALID_DIFFICULTY_2 = "Hard";
}