<?php
namespace abqtrails;

/**
 * Trail Class
 *
 * This is a Class that stores data for a Trail in the ABQ Trails app.
 *
 * @author Scott Wells <swells19@cnm.edu>
 * @version 1.0.0
 **/
class Trail {

	/**
	 * id for this Trail; this is a primary key
	 * @var Uuid $trailId
	 **/
	private $trailId;
	/**
	 * url for this Trail avatar photo
	 * @var Url $trailAvatarUrl
	 **/
	private $trailAvatarUrl;
	/**
	 * description of this Trail, to be included with Trail name
	 * @var string $trailDescription
	 **/
	private $trailDescription;
	/**
	 * measure of the highest point of the Trail, in feet
	 * @var string $trailHigh
	 **/
	private $trailHigh;
	/**
	 * measure of the latitude coordinate of the Trail, in degrees/minutes/seconds
	 * @var string $trailLatitude
	 **/
	private $trailLatitude;
	/**
	 * measure of the length of the Trail, in miles
	 * @var float $trailLength
	 **/
	private $trailLength;
	/**
	 * measure of the longitude of the Trail, in degrees/minutes/seconds
	 * @var string $trailLongitude
	 **/
	private $trailLongitude;
	/**
	 * measure of the lowest point of the Trail, in feet
	 * @var string $trailLow
	 **/
	private $trailLow;
	/**
	 * the name of this Trail
	 * @var string $trailName
	 **/
	private $trailName;






}