import {Component, OnInit, ViewChild,} from "@angular/core";
import {Status} from "../shared/interfaces/status"
import {Profile} from "../shared/interfaces/profile";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	templateUrl:"./update-profile.component.html"
})

//set template URL and the selector for the ng powered html

export class UpdateProfileComponent implements OnInit{


	updateProfileForm : FormGroup;
	status : Status = {status: null, message: null, type: null};

	constructor(private formBuilder : FormBuilder, private profileService : ProfileService){
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
			id: null,
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
	}



