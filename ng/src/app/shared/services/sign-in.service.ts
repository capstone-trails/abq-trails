
import {Injectable} from "@angular/core";


import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign-in";


import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class SignUpService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private apiUrl = "https://bootcamp-coders.cnm.edu/~swells19/abq-trails/public_html/api/";


	// Sign-In API -- POST
	postSignIn(signIn : SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signIn));
	}

	//Sign-Out API -- GET
	getSignOut(signOut : SignOut) : Observable<Status> {
		return(this.http.get<Status>(this.apiUrl, signOut))
	}

}