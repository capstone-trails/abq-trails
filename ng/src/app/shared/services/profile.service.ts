import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Profile} from "../interfaces/profile";
import {Observable} from "rxjs/internal/Observable";

@Injectable ()
export class ProfileService  {

	constructor(protected http : HttpClient) {

	}

	//define the API endpoint
	private profileUrl = "api/profile/";

	// call to the Profile API and edit the profile in question
	updateProfile(profile: Profile) : Observable<Status> {
		return(this.http.put<Status>(this.profileUrl, profile));
	}

	// call to the Profile API and get a Profile object by its id
	getProfileByProfileId(id: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + id));
	}
}