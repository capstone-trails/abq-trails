<?php
namespace abqtrails;
use mysql_xdevapi\Exception;

/**
 * Class tag
 * @package abqtrails
 *
 * @author Robert Dominguez <rdominguez45@cnm.edu
 **/
class tag{
	/**
	 * id for this Tag; this is the primary key
	 * @var Uuid $tagId
	 **/
	private $tagId;
	/**
	 * name of the tag
	 * @var varchar $tagName
	 **/
	private $tagName;

	/**
	 * constructor for this Tag
	 *
	 * @param string|Uuid $newTagId id of this Tag or null if a new Tag
	 * @param string $newTagName string containing the tag name
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if the data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

}