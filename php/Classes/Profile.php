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
 * @param string $newProfileEmail unique string containing unique profile email address
 * @param string $newProfileFirstName string containing profile user first name
 * @param string $newProfileHash string containing hashed profile password
 * @param string $newProfileLastName string containing profile user last name
 * @param string $newProfileUsername string containing unique profile username
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 **/
public function __construct($newProfileId, $newProfileActivationToken, $newProfileAvatarUrl, $newProfileEmail, $newProfileFirstName, $newProfileHash, $newProfileLastName, $newProfileUsername) {
	try {
		$this->setProfileId($newProfileId);
		$this->setProfileActivationToken($newProfileActivationToken);
		$this->setProfileAvatarUrl($newProfileAvatarUrl);
		$this->setProfileEmail($newProfileEmail);
		$this->setProfileFirstName($newProfileFirstName);
		$this->setProfileHash($newProfileHash);
		$this->setProfileLastName($newProfileLastName);
		$this->setProfileUsername($newProfileUsername);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}




}

