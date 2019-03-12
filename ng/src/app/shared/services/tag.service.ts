import {Injectable} from "@angular/core";

import {Tag} from "../interfaces/tag.ts";


import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http : HttpClient ) {}

	//define the API endpoint
	private tagUrl = "https://bootcamp-coders.cnm.edu/~rluna41/abq-trails/public_html/api/tag/";


	// call to the Tag API and create the tag in question
	createTag(tag : Tag) : Observable<Status> {
		return(this.http.post<Status>(this.tagUrl, tag));
	}

	// call to the Tag API and get a tag object based on its Id
	getTag(userId : string) : Observable<Tag> {
		return(this.http.get<Tag>(this.tagUrl + userId));

	}

	// call to the API and get an array of tags based off the profileId
	getDetailedTag(userId : string) : Observable<TagPosts[]> {
		return(this.http.get<TagPosts[]>(this.tagUrl + "?postUserId=" + userId ));

	}

	//call to the API and get an array of all the tags in the database
	getAllTags() : Observable<Tag> {
		return(this.http.get<Tag>(this.tagUrl));

	}


}