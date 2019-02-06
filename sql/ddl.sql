ALTER DATABASE ddl CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32) NOT NUll,
	profileAvatarUrl VARCHAR(255) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileFirstName VARCHAR(32),
	profileHash CHAR(97),
	profileLastName VARCHAR(32),
	profileUsername VARCHAR(32),
	UNIQUE (profileEmail),
	UNIQUE (profileUsername)
	PRIMARY KEY (profileId)
);

CREATE TABLE trail (
	trailId BINARY(16) NOT NULL,
	trailAvatarUrl VARCHAR(255) NOT NULL,
	trailDescription VARCHAR(280),
	trailHigh VARCHAR(8),
	trailLatitude DECIMAL(9, 6) NOT NULL,
	trailLength DECIMAL(9, 6) NOT NULL,
	trailLongitude DECIMAL(9, 6) NOT NULL,
	trailLow VARCHAR(8),
	trailName VARCHAR(128) NOT NULL,
	PRIMARY KEY (trailId)
);

CREATE TABLE photo (
	photoId BINARY(16) NOT NULL,
	photoProfileId BINARY(16) NOT NULL,
	photoTrailId BINARY(16) NOT NULL,
	photoDateTime DATETIME(6) NOT NULL,
	photoUrl VARCHAR(255) NOT NULL,
	INDEX (photoProfileId),
	INDEX (photoTrailId),
	FOREIGN KEY (photoProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (photoTrailId) REFERENCES trail(trailId),
	PRIMARY KEY (photoId)
);

CREATE TABLE tag (
	tagId BINARY(16) NOT NULL,
	tagName VARCHAR(32),
	PRIMARY KEY (tagId)
);

CREATE TABLE trailTag (
	trailTagTagId BINARY(16) NOT NULL,
	trailTagTrailId BINARY(16) NOT NULL,
	trailTagProfileId BINARY(16) NOT NULL,
	INDEX (trailTagTagId),
	INDEX (trailTagTrailId),
	INDEX (trailTagProfileId),
	FOREIGN KEY (trailTagTagId) REFERENCES tag(tagId),
	FOREIGN KEY (trailTagTrailId) REFERENCES trail(trailId),
	FOREIGN KEY (trailTagProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (tagId, profileId)
);

CREATE TABLE rating (
	ratingId BINARY(16) NOT NULL,
	ratingProfileId BINARY(16) NOT NULL,
	ratingTrailId BINARY(16) NOT NULL,
	ratingDifficulty VARCHAR(16),
	ratingValue VARCHAR(5),
	INDEX (ratingProfileId),
	INDEX (ratingTrailId),
	FOREIGN KEY (ratingProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (ratingTrailId) REFERENCES trail(trailId),
	PRIMARY KEY (ratingId)
);