
import {Injectable} from "@angular/core";


import {Profile} from "../interfaces/profile";



import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class ApiService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private apiUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/";

	// Sign-Up API -- POST
	postSignUp(signUp : SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signUp));
	}

	// Sign-In API -- POST
	postSignIn(signIn : )
}