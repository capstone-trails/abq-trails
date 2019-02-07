<?php
namespace abqtrails;

use \abqtrails\Trail;

//grab the class in question
require_once("autoload.php");

//grab the uuid generator
require_once("../../vendor/autoload.php");

/**
 * Full PHPUnit test for the Trail class
 *
 * This is a complete PHPUnit test of the Trail class. It is complete because *ALL* mySQL/PDO enabled methods are tested
 * for both invalid and valid inputs.
 *
 * @see \abqtrails\Trail
 * @author Scott Wells <swells19@cnm.edu>
 **/