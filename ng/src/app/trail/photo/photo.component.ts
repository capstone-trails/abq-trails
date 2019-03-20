import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../../shared/interfaces/status";
import {Profile} from "../../shared/interfaces/profile";
import {ProfileService} from "../../shared/services/profile.service";
import {Photo} from "../../shared/interfaces/photo";
import {PhotoService} from "../../shared/services/photo.service";
import {AuthService} from "../../shared/services/auth-service";
import {FileUploader} from "ng2-file-upload";
import {CookieService} from "ngx-cookie";
import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";


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
		cloudinaryResult: null,
		photoDateTime: null,
		photoUrl: null
	};

	status: Status = null;

	trailId = {photoTrailId: "86bf1c24-0d40-453f-8836-35c012440b7c"};
	public uploader: FileUploader = new FileUploader(
		{
			itemAlias: 'photo',
			url: './api/photo/',
			headers: [
				//you will alos want to include a JWT-TOKEN
				{name: 'X-XSRF-TOKEN', value: this.cookieService.get('XSRF-TOKEN')}
			],
			additionalParameter: this.trailId,
		}
	);


	constructor(
		private router: Router,
		private profileService: ProfileService,
		private authService: AuthService,
		private cookieService: CookieService,
		private photoService: PhotoService,
		private activeModal: NgbActiveModal
	) {}


	ngOnInit(): void {
	}


	uploadPhoto(): void {
		console.log(this.uploader);
		this.uploader.uploadAll();
	}


	closeModalButton(){
		this.activeModal.dismiss("Cross click")
	}

}





