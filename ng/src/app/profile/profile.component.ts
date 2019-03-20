import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {AuthService} from "../shared/services/auth-service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import {UpdateProfileComponent} from "./update-profile/update-profile.component";
import {SignInService} from "../shared/services/sign-in.service";


@Component({
	templateUrl: "./profile.component.html",
	styleUrls: ["./profile.component.css"],
	selector: "profile",
})


export class ProfileComponent implements OnInit {

	profile: Profile = {
		id: null,
		profileAvatarUrl: null,
		profileEmail: null,
		profileFirstName: null,
		profileLastName: null,
		profilePassword: null,
		profilePasswordConfirm: null,
		profileUsername: null
	};

	status: Status = null;

	tempId: string = this.authService.decodeJwt().auth.profileId;


	constructor(private router: Router, private profileService: ProfileService, private authService: AuthService, private modalService: NgbModal, private signInService: SignInService) {
	}


	ngOnInit(): void {
		this.getProfile();
	}


	getProfile (): void {
		//for testing
		this.profileService.getProfileByProfileId(this.tempId)
			.subscribe(profile => this.profile = profile);

		//live
		// 	this.profileService.getProfile(this.profileId)
		// 		.subscribe(profile => this.profile = profile);
		// }

		}


	openUpdateProfileModal() {
		this.modalService.open(UpdateProfileComponent);
	}


}





