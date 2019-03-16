import {Component, OnInit, Input} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {AuthService} from "../shared/services/auth-service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';

//modal testing
@Component({
	selector: 'ngbd-modal-content',
	template: "../update-profile/update-profile.component.html"
})

export class NgbdModalContent {
	@Input() name;

	constructor(public activeModal: NgbActiveModal) {}
}

@Component({
	selector: 'ngbd-modal-component',
	templateUrl: './profile.component.html'
})
export class NgbdModalComponent {
	constructor(private modalService: NgbModal) {}

	open() {
		const modalRef = this.modalService.open(NgbdModalContent);
		modalRef.componentInstance.name = 'World';
	}
}
















///this works
@Component({
	templateUrl: "./profile.component.html",
	selector: "profile",
	//'ngb-modal-basic'
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


	constructor(protected profileService: ProfileService, private authService: AuthService) {
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

}





