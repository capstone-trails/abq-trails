import {Component, OnInit, Input} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {AuthService} from "../shared/services/auth-service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
	selector: 'ngbd-modal-content',
	template:`
		<div class="modal-header">
			<h4 class="modal-title">Update Profile</h4>

			<button type="button" class="close" aria-label="Close" (click)="activeModal.dismiss('Cross click')">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<div class="modal-body">
			<form [formGroup]="updateProfileForm" (submit)="updateProfile()" novalidate>

				<div class="form-row">

					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" formControlName="profileEmail">
					</div>

					<div class="form-group col-md-6">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" formControlName="profileUsername">
					</div>

					<div class="form-group col-md-6">
						<label for="firstName">First Name</label>
						<input type="text" class="form-control" id="firstName" formControlName="profileFirstName">
					</div>

					<div class="form-group col-md-6">
						<label for="lastName">Last Name</label>
						<input type="Text" class="form-control" id="lastName" formControlName="profileLastName">
					</div>

					<button type="button" class="btn btn-secondary">Add a photo</button>

				</div>

				<button type="submit" class="btn btn-secondary my-5">Submit</button>

			</form>
		</div>

		<div class="modal-footer">

			<button type="button" class="btn btn-outline-dark" (click)="activeModal.close('Close click')">Close</button>

		</div>
	`,
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









@Component({
	templateUrl: "./profile.component.html",
	styleUrls: [""],
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





