ALTER DATABASE trails CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- delete existing tables
DROP TABLE IF EXISTS trailTag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS rating;
DROP TABLE IF EXISTS photo;
DROP TABLE IF EXISTS trail;
DROP TABLE IF EXISTS profile;

-- create the profile entity
CREATE TABLE profile (
   -- profileId is the primary key
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAvatarUrl VARCHAR(255),
	profileEmail VARCHAR(128) NOT NULL,
	profileFirstName VARCHAR(32) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileLastName VARCHAR(32) NOT NULL,
	profileUsername VARCHAR(32) NOT NULL,
	UNIQUE (profileEmail),
	UNIQUE (profileUsername),
	PRIMARY KEY (profileId)
);

-- create the trail entity
CREATE TABLE trail (
   -- trailId is the primary key
	trailId BINARY(16) NOT NULL,
	trailAvatarUrl VARCHAR(255) NOT NULL,
	trailDescription VARCHAR(280),
	trailHigh SMALLINT,
	trailLatitude DECIMAL(12, 9) NOT NULL,
	trailLength DECIMAL(5, 1),
	trailLongitude DECIMAL(12, 9) NOT NULL,
	trailLow SMALLINT,
	trailName VARCHAR(128) NOT NULL,
	PRIMARY KEY (trailId)
);

-- create the photo entity
CREATE TABLE photo (
   -- photoId is the primary key
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

-- create the rating entity
CREATE TABLE rating (
	ratingProfileId BINARY(16) NOT NULL,
	ratingTrailId BINARY(16) NOT NULL,
	ratingDifficulty TINYINT,
	ratingValue TINYINT,
	INDEX (ratingProfileId),
	INDEX (ratingTrailId),
	FOREIGN KEY (ratingProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (ratingTrailId) REFERENCES trail(trailId),
	PRIMARY KEY (ratingProfileId, ratingTrailId)
);

-- create the tag entity
CREATE TABLE tag (
   -- tagId is the primary key
	tagId BINARY(16) NOT NULL,
	tagName VARCHAR(32)NOT NULL,
	PRIMARY KEY (tagId)
);

-- create the trail tag entity
CREATE TABLE trailTag (
   -- this is try hard entity
	trailTagTagId BINARY(16) NOT NULL,
	trailTagTrailId BINARY(16) NOT NULL,
	trailTagProfileId BINARY(16) NOT NULL,
	INDEX (trailTagTagId),
	INDEX (trailTagTrailId),
	INDEX (trailTagProfileId),
	FOREIGN KEY (trailTagTagId) REFERENCES tag(tagId),
	FOREIGN KEY (trailTagTrailId) REFERENCES trail(trailId),
	FOREIGN KEY (trailTagProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (trailTagTagId, trailTagTrailId)
);