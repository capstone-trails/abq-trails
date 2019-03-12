import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Trail} from "../interfaces/trail";
import {Observable} from "rxjs/internal/Observable";

@Injectable()
export class ApiService {

	constructor(protected http: HttpClient) {}

	//define the API endpoint
	private trailUrl = "/api/trail/";

	//call to the trail API and get the trail
	getTrailById(trailId : string) : Observable<Status> {
		return(this.http.get<Status>(this.trailUrl), trailId);
	}

	getTrailsByName(trail: Trail) : Observable<Trail[]> {
		return(this.http.get<Trail[]>(this.trailUrl, trail));
	}

	getAllTrails() : Observable<Trail[]> {
		return(this.http.get<Trail[]>(this.trailUrl));
	}

}