import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Photo} from "../interfaces/photo";
import {Observable} from "rxjs/internal/Observable";

@Injectable ()
export class PhotoService {

	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private photoUrl = "api/photo/";

	getPhotoByPhotoId(photoId: string): Observable<Photo[]> {
		return (this.http.get<Photo[]>(this.photoUrl + "?photoProfileId="  + photoId));
	}

	uploadPhoto(photoId: string): Observable<Photo> {
		return(this.http.post<Photo>(this.photoUrl, photoId));
	}
}