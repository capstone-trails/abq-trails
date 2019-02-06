<?php
namespace abqtrails;

/**
 *
 * This profile is used to input and view data and photos on ABQ Trails web application
 *
 * @author Cassandra Romero <cromero278@cnm.edu>
 *
 */

class Profile {

	/**
	 * id for user profile, this is a primary key
	 * @var Uuid $profileId
	 */
	private $profileId;
	/**
	 * One-time activation token used for profile account creation
	 * @var $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * url for author avatar (photo)
	 * @var $profileAvatarUrl
	 */
	private $profileAvatarUrl;
/**
 * profile email address, must be unique
 * @var $profileEmail
 */
	private $profileEmail;
/**
 * encrypted profile password
 * @var $profileHash
 */
	private $profileHash;
}

