import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Tag} from "../interfaces/tag";
import {Observable} from "rxjs/internal/Observable";


@Injectable ()
export class TagService {

	constructor(protected http : HttpClient ) {}

	//define the API endpoint
	private tagUrl = "https://bootcamp-coders.cnm.edu/~rluna41/abq-trails/public_html/api/tag/";


	// call to the Tag API and create the tag in question
	createTag(tag : Tag) : Observable<Status> {
		return(this.http.post<Status>(this.tagUrl, tag));
	}

	// call to the Tag API and get a tag object based on its Id
	getTagByTagId(tagId : string) : Observable<Tag> {
		return(this.http.get<Tag>(this.tagUrl + tagId));

	}

	// call to the API and get an array of tags based off the profileId
	getTagByTagName(tagName : string) : Observable<Tag[]> {
		return(this.http.get<Tag[]>(this.tagUrl + "?tagName=" + tagName ));

	}

	//call to the API and get an array of all the tags in the database
	getAllTags() : Observable<Tag> {
		return(this.http.get<Tag>(this.tagUrl));

	}


}