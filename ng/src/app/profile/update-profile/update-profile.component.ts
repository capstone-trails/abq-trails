import {Component, OnInit, ViewChild,} from "@angular/core";
import {Status} from "../../shared/interfaces/status"
import {Profile} from "../../shared/interfaces/profile";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ProfileService} from "../../shared/services/profile.service";
import {AuthService} from "../../shared/services/auth-service";
import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";

@Component({
	templateUrl:"./update-profile.component.html",
	selector: "update-profile"
})

//set template URL and the selector for the ng powered html

export class UpdateProfileComponent implements OnInit{


	updateProfileForm : FormGroup;
	status : Status = {status: null, message: null, type: null};
	tempId: string = this.authService.decodeJwt().auth.profileId;


	constructor(private formBuilder : FormBuilder, private profileService : ProfileService, private authService: AuthService, private activeModal: NgbActiveModal){
	}

	ngOnInit() : void {
		this.updateProfileForm = this.formBuilder.group({
			profileAvatarUrl : ["", [Validators.maxLength(255)]],
			profileEmail: ["", [Validators.maxLength(128)]],
			profileFirstName: ["", [Validators.maxLength(32)]],
			profileLastName: ["", [Validators.maxLength(32)]],
			profileUsername: ["", [Validators.maxLength(32), Validators.required]],
		});
		this.status = {status: null, message: null, type: null}
	}
	updateProfile() : void {
		let profile: Profile = {
			id: this.tempId,
			profileAvatarUrl: "http://kittens.photo",
			profileEmail: this.updateProfileForm.value.email,
			profileFirstName: this.updateProfileForm.value.firstName,
			profileLastName: this.updateProfileForm.value.lastName,
			profilePassword: null,
			profilePasswordConfirm: null,
			profileUsername: this.updateProfileForm.value.username
		};
		this.profileService.updateProfile(profile).subscribe(status => {
			this.status = status;

			if(this.status.status === 200) {
				alert(status.message);

			}
		})
	}

	closeModalButton(){
		this.activeModal.dismiss("Cross click")
	}
	}



