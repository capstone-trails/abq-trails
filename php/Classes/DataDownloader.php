<?php

namespace CapstoneTrails\AbqTrails;

require_once("autoload.php");

require_once("/etc/apache2/capstone-mysql/Secrets.php");

require_once(dirname(__DIR__, 1) . "/lib/uuid.php");


class DataDownloader() {

	public static function pullTrails() {
	$trailsVar = null;
	$urlBase = "https://www.hikingproject.com/data/get-trails?lat=35.085470&lon=-106.649072&maxDistance=25&maxResults=500&key=200416450-0de1cd3b087cf27750e880bc07021975"
	$trailsVar = self::readDataJson($urlBase);
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/trails.ini");
	$imgCount=0;
	$sumCount=0;
	$trailCount=0;
	foreach($trailsVar as $value) {
			$trailId = generateUuidV4();
			$trailAvatarUrl = $value->imgMedium;
			//missing avatar url counter
				if (empty($value->imgMedium)===true){
					$trailAvatarUrl = "Trail needs an avatar";
					$imgCount = $imgCount + 1;
				}
			$trailDescription = $value->summary;
			//missing trail description counter
	}
	}
}