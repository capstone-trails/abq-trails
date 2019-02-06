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
 * profile user's first name
 * @var $profileFirstName
 */
	private $profileFirstName;
/**
 * encrypted profile password
 * @var $profileHash
*/
	private $profileHash;
/**
 * profile user's last name
 * @var $profileLastName
 */
	private $profileLastName;
/**
 * profile username, must be unique
 * @var $profileUsername
 */
	private $profileUsername;

/**
 * constructor for Author
 *
 * @param string|Uuid $newProfileId id for this profile
 * @param string $newProfileActivationToken string containing activation token for account creation
 * @param string $newProfileAvatarUrl string containing url of profile avatar
 * @parma string $newProfileEmail unique string containing unique profile email address
 */

}

