<?php
namespace abqtrails;
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
	 * @param string|Uuid $newRatingId
	 * @param string|Uuid $newRatingProfileId
	 * @param string|Uuid $newRatingTrailId
	 * @param string $newRatingDifficulty
	 * @param string $newRatingValue
	 **/
}