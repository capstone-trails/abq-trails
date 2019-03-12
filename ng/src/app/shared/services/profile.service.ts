
import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import  {Profile} from "../interfaces/profile";

@Injectable()
export class ApiService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private apiUrl = "https://bootcamp-coders.cnm.edu/~rdominguez45/abq-trails/public_html/api/";

	// Sign-Up API -- POST
	postSignUp(signUp : SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signUp));
	}

	// Sign-In API -- POST
	postSignIn(signIn : )
}