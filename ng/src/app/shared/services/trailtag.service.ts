import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/internal/Observable";
import {Trailtag} from "../interfaces/trailtag";

@Injectable()
export class TrailtagService {
	constructor(protected http: HttpClient) {
	}

	//define API endpoint
	private trailTagUrl = "https://bootcamp-coders.cnm.edu/~cromero278/abq-trails/public_html/api/trailtag/";;

	//call the trail tag API and create a new trail tag
	createTrailTag(trailTag : Trailtag) : Observable<Status> {
		return (this.http.post<Status>(this.trailTagUrl, trailTag))
	}

	//call the trail tag API and delete the tag
	deleteTrailTag(trailTag : Trailtag) :Observable<Status> {
		return (this.http.put<Status>(this.trailTagUrl, trailTag))
	}
}