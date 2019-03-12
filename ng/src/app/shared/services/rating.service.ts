import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/internal/Observable";
import {Profile} from "../interfaces/profile";
import {Rating} from "../interfaces/rating";
import {Trail} from "../interfaces/trail";


@Injectable()
export class RatingService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private ratingUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/rating/";

	createRating(rating : Rating) : Observable<Status> {
		return(this.http.post<Status>(this.ratingUrl + rating));
	}

	getRatingByProfileIdAndTrailId(ratingProfileId : string, ratingTrailId : string) : Observable<Rating> {
		return(this.http.get<Rating>(this.ratingUrl, {params: new HttpParams().set("ratingProfileId", ratingProfileId).set("ratingTrailId", ratingTrailId)}));
	}

	getRatingByProfileId(ratingProfileId : string) : Observable<Rating[]> {
		return(this.http.get<Rating[]>(this.ratingUrl, {params: new HttpParams().set("ratingProfileId", ratingProfileId)}));
	}

	getRatingByTrailId(ratingTrailId : string) : Observable<Rating[]> {
		return(this.http.get<Rating[]>(this.ratingUrl, {params: new HttpParams().set("ratingTrailId", ratingTrailId)}));
	}
}