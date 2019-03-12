import {Injectable} from "@angular/core";

import {Status} from "../interfaces/status";
import {User} from "../interfaces/user";
import {UserPosts} from "../interfaces/ueserPosts";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http : HttpClient ) {}

	//define the API endpoint
	private tagUrl = "https://bootcamp-coders.cnm.edu/~rluna41/abq-trails/public_html/api/tag/";


	// call to the Tag API and create the tag in question
	createUser(user : User) : Observable<Status> {
		return(this.http.post<Status>(this.tagUrl, user));
	}

	// call to the Tag API and get a tag object based on its Id
	getUser(userId : string) : Observable<User> {
		return(this.http.get<User>(this.tagUrl + userId));

	}

	// call to the API and get an array of tags based off the profileId
	getDetailedUser(userId : string) : Observable<UserPosts[]> {
		return(this.http.get<UserPosts[]>(this.tagUrl + "?postUserId=" + userId ));

	}

	//call to the API and get an array of all the tags in the database
	getAllUsers() : Observable<User> {
		return(this.http.get<User>(this.tagUrl));

	}

	/**
	 * Get for tag
	 * @param $method
	 **/

	if($method === "GET") {
	//set XSRF cookie
	setXsrfCookie();

	//get a specific trail based on arguments provided and update reply
	if(empty($id) === false) {
	$reply->data = Tag::getTagByTagId($pdo, $id);
} else if(empty($tagName) === false) {
	$reply->data = Tag::getTagByTagName($pdo, $tagName)->toArray();
} else {
	$reply->data = Tag::getAllTags($pdo)->toArray();
}

/**
 * Post for tag
 **/
} else if($method === "POST") {
	//enforce that the end user has a XSRF token
	verifyXsrf();
	//enforce the end user has a JWT token
//		validateJwtHeader();
	//decode the response from the front end
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);


	if(empty($requestObject->tagName) === true) {
		throw (new \InvalidArgumentException("Tag needs a name", 405));
	}
}