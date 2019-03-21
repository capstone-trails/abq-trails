import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Rating} from "../interfaces/rating";
import {Observable} from "rxjs/internal/Observable";


@Injectable()
export class RatingService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private ratingUrl = "/api/rating/";

	createRating(rating : Rating) : Observable<Status> {
		return(this.http.post<Status>(this.ratingUrl, rating));
	}

	getRatingByRatingProfileIdAndRatingTrailId(ratingProfileId : string, ratingTrailId : string) : Observable<Rating> {
		return(this.http.get<Rating>(this.ratingUrl, {params: new HttpParams().set("ratingProfileId", ratingProfileId).set("ratingTrailId", ratingTrailId)}));
	}

	getRatingByRatingProfileId(ratingProfileId : string) : Observable<Rating[]> {
		return(this.http.get<Rating[]>(this.ratingUrl, {params: new HttpParams().set("ratingProfileId", ratingProfileId)}));
	}

	getRatingByRatingTrailId(ratingTrailId : string) : Observable<Rating[]> {
		return(this.http.get<Rating[]>(this.ratingUrl, {params: new HttpParams().set("ratingTrailId", ratingTrailId)}));
	}
}