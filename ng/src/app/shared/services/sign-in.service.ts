import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign-in";
import {Observable} from "rxjs/internal/Observable";

@Injectable()
export class SignInService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private signInUrl = "/api/sign-in/";
	private signOutUrl = "/api/sign-out/";


	postSignIn(signIn : SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.signInUrl, signIn));
	}

	getSignOut() : Observable<Status> {
		return(this.http.get<Status>(this.signOutUrl));
	}

}