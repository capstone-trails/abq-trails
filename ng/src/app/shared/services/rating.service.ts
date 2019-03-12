import {Injectable} from "@angular/core";

import {Profile} from "../interfaces/profile";
import {Rating} from "../interfaces/rating";
import {Trail} from "../interfaces/trail";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable()
export class RatingService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private ratingUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/rating/";

	private id = profileId + trailId;

	createRating(rating : Rating) : Observable<Status> {
		return(this.http.post<Status>(this.ratingUrl + rating));
	}

	getRatingByProfileIdAndTrailId(ratingProfileId : string, ratingTrailId : stirng) : Observable<Rating> {
		return(this.http.get<Rating>(this.ratingUrl, {params: new HttpParams().set("ratingProfileId", ratingProfileId).set("ratingTrailId", ratingTrailId)}));
	}

	getRatingByProfileId

}