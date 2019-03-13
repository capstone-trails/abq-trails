/*
 this component is for signing up to use the site.
 */

//import needed modules for the sign-up component
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Observable} from "rxjs/internal/Observable";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status"
import {SignUp} from "../shared/interfaces/sign-up";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUpService} from "../shared/services/sign-up.service";

@Component({
	templateUrl:"./sign-up.component.html"
})

//set template URL and the selector for the ng powered html

export class SignUpComponent implements OnInit{


	signUpForm : FormGroup;
	status : Status = {status: null, message: null, type: null};

	constructor(private formBuilder : FormBuilder, private signUpService : SignUpService){
	}

	ngOnInit() : void {
		this.signUpForm = this.formBuilder.group({
			avatarUrl: ["", [Validators.maxLength(255)]],
			email: ["", [Validators.maxLength(128), Validators.required]],
			firstName: ["", [Validators.maxLength(32), Validators.required]],
			lastName: ["", [Validators.maxLength(32), Validators.required]],
			password: ["", [Validators.maxLength(128)], Validators.required],
			passwordConfirm: ["", [Validators.maxLength(128)], Validators.required],
			username: ["", [Validators.maxLength(32), Validators.required]],
		});
		this.status = {status: null, message: null, type: null}
	}
	createSignUp() : void {
		let signUp : SignUp = {profileAvatarUrl: "http://kittens.photo", profileEmail : this.signUpForm.value.email, profileFirstName : this.signUpForm.value.firstName, profileLastName : this.signUpForm.value.lastName, profilePassword : this.signUpForm.value.password, profilePasswordConfirm : this.signUpForm.value.passwordConfirm, profileUsername : this.signUpForm.value.username};
		this.signUpService.createProfile(signUp).subscribe(status=> {
			this.status = status;

			if(this.status.status === 200){
				alert(status.message);

			}
		})
	}


	}
