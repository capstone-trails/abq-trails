ALTER DATABASE ddl CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken,
	profileAvatarUrl,
	profileEmail,
	profileFirstName,
	profileHash,
	profileLastName,
	profileUsername

	UNIQUE (profileId),
	UNIQUE (profileAvatarUrl),
	UNIQUE (profileEmail),

	PRIMARY KEY (profileId)
)