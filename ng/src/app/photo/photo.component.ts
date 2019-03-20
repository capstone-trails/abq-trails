import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {Photo} from "../shared/interfaces/photo";
import {PhotoService} from "../shared/services/photo.service";
import {AuthService} from "../shared/services/auth-service";
import {FileUploader} from "ng2-file-upload";
import {CookieService} from "ngx-cookie";


///this works
@Component({
	templateUrl: "./photo.component.html",
	selector: "photo",
})


export class PhotoComponent implements OnInit {

	photo: Photo = {
		id: null,
		photoProfileId: null,
		photoTrailId: null,
		photoCloudinaryToken: null,
		photoDateTime: null,
		photoUrl: null
	};

	status: Status = null;


	tempId: string = this.authService.decodeJwt().auth.profileId;

	public uploader: FileUploader = new FileUploader(
		{
			itemAlias: 'photo',
			url: './api/photo/',
			headers: [
				//you will also want to include a JWT-TOKEN
				{name: 'X-XSRF-TOKEN', value: this.cookieService.get('XSRF-TOKEN')}
			],
		}
	);


	constructor(private router: Router, private profileService: ProfileService, private authService: AuthService, private cookieService: CookieService, private photoService: PhotoService) {
	}


	ngOnInit(): void {
		this.getPhotoByPhotoId();

	}

	getPhotoByPhotoId (): void {
		this.photoService.getPhotoByPhotoId(this.photo.id);
	}

	uploadPhoto(): void {
		this.uploader.uploadAll();
	}

}





