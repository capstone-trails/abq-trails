import {Injectable} from "@angular/core";


import {Trail} from "../interfaces/trail";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class ApiService {

	constructor(protected http: HttpClient) {}

	//define the API endpoint
	private trailUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/trail/";

	//call to the trail API and get the trail
	getTrailById(trailId : string) : Observable<Trail> {
		return(this.http.get<Trail>(this.trailUrl), trailId);
	}

	getTrailsByName(trail: Trail) : Observable<Trail[]> {
		return(this.http.get<Trail[]>(this.trailUrl, trail));
	}

	getAllTrails(trail : Trail) : Observable<Trail[]> {
		return(this.http.get<Trail[]>(this.trailUrl, trail));
	}

}