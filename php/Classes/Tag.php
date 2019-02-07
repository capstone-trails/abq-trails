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
	public function __construct($newTagId, string $newTagName) {
		try {
			$this->setTagId($newTagId);
			$this->setTagName($newTagName);
		}
		//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}
	}

	/**
	 * accessor method for tag id
	 *
	 * @return Uuid value of tag id
	 **/
	public function getTagId() : Uuid {
		return($this->tagId);
	}

	/**
	 * mutator method for tag id
	 *
	 * @param Uuid|string $newTagId new value of tag id
	 * @throws \TypeError if $newTagId is not positive
	 * @throws \TypeError if $newTagId is not a Uuid or string
	 **/
	public function setTagId($newTagId) : void {
		try {
			$uuid = self::validateUuid($newTagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0));
		}

		//convert and store the tag id
		$this->tagId = $uuid;
	}

	/**
	 * accessor method for tag name
	 *
	 * @return string value of tag name
	 **/
	public function getTagName() : string {
		return($this->tagName);
	}

	/**
	 * mutator method for tag name
	 *
	 * @param string $newTagName new value of tag name
	 * @throws \InvalidArgumentException if $newTagName
	 * @throws \RangeException if $newTagName is > 32 characters
	 * @throws \TypeError if $newTagName is not a string
	 **/
	public function setTagName(string $newTagName) : void {
		//verify the tag name is secure
		$newTagName = trim($newTagName);
		$newTagName = filter_var($$newTagName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTagName)=== true) {
			throw (new \InvalidArgumentException("Tag name is empty or insecure"));
		}

		// verify the tag name will fit in the database
		if(strlen($newTagName) > 32){
			throw (new \RangeException("Tag name too large"));
		}

		// store the tweet content
		$this->tagName = $newTagName;
	}


}