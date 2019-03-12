import {Injectable} from "@angular/core";

import {Profile} from "../interfaces/profile";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class ApiService {

	constructor(protected http: HttpClient) {}

	//define the API endpoint
	private trailUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/trail/";

	getTrail

}