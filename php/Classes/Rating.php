<?php
namespace abqtrails;
use mysql_xdevapi\Exception;

/**
 * Class rating
 * @package abqtrails
 *
 * @author Robert Dominguez <rdominguez45@cnm.edu
 **/
class rating {
	/**
	 * id for this Rating; this is the primary key
	 * @var Uuid $ratingId
	 **/
	private $ratingId;
	/**
	 * id of the profile that rated the trail; this is a foreign key
	 * @var Uuid $ratingProfileId
	 **/
	private $ratingProfileId;
	/**
	 * id of the trail being rated; this is a foreign key
	 * @var Uuid $ratingTrailId
	 **/
	private $ratingTrailId;
	/**
	 * what the difficultly of the trail is
	 * @var $ratingDifficulty
	 **/
	private $ratingDifficulty;
	/**
	 * what might be on the trail
	 * @var $ratingValue
	 **/
	private $ratingValue;

	/**
	 * constructor for this Rating
	 *
	 * @param string|Uuid $newRatingId id of this rating or null if a new rating
	 * @param string|Uuid $newRatingProfileId id of the profile that's making the rating
	 * @param string|Uuid $newRatingTrailId id of the trail that's being rated
	 * @param string $newRatingDifficulty string that tells how difficult the trail is
	 * @param string $newRatingValue string that tells what might be on the trails.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if some other exception occurs
	 * @Documention https://php.net/manual/en/language.oop5.decon.php
	 **/
//test
}