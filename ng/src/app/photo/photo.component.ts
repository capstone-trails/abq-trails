import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {Photo} from "../shared/interfaces/photo";
import {PhotoService} from "../shared/services/photo.service";
import {AuthService} from "../shared/services/auth-service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';


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


	constructor(private router: Router, private profileService: ProfileService, private authService: AuthService, private modalService: NgbModal, private photoService: PhotoService) {
	}


	ngOnInit(): void {
		this.getPhotoByPhotoId();
	}

	getPhotoByPhotoId (): void {
		this.photoService.getPhotoByPhotoId(this.photo.id);
	}

}





