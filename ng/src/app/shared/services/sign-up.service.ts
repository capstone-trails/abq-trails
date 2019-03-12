import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/internal/Observable";
import {SignUp} from "../interfaces/sign-up";

@Injectable()
export class SignUpService {
	constructor(protected http : HttpClient) {
	}

	//define the API endpoint
	private signUpUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/";

	// Sign-Up API -- POST
	createProfile(signUp : SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.signUpUrl, signUp));
	}

}