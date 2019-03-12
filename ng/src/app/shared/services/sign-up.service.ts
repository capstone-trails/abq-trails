
import {Injectable} from "@angular/core";


import {Status} from "../interfaces/status";
import {SignUp} from "../interfaces/sign-up";


import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class SignUpService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private apiUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/";

	// Sign-Up API -- POST
	createProfile(signUp : SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signUp));
	}

}