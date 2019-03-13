/*
 this component is for signing up to use the site.
 */

//import needed modules for the sign-up component
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status"
import {SignIn} from "../shared/interfaces/sign-in";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CookieService} from "ng2-cookies";
import {SignInService} from "../shared/services/sign-in.service";


@Component({
	templateUrl:"./sign-in.component.html"
})

//set template URL and the selector for the ng powered html

export class SignInComponent {


	signInForm : FormGroup;
	status : Status = {status: null, message: null, type: null};

	constructor(private formBuilder : FormBuilder, private signInService : SignInService, private router: Router, private cookieService: CookieService){
	}

	ngOnInit() : void {
		this.signInForm = this.formBuilder.group({
			avatarUrl : ["", [Validators.maxLength(255)]],
			email: ["", [Validators.maxLength(128), Validators.required]],
			firstName: ["", [Validators.maxLength(32), Validators.required]],
			lastName: ["", [Validators.maxLength(32), Validators.required]],
			password: ["", [Validators.maxLength(128), Validators.required]],
			passwordConfirm: ["", [Validators.maxLength(128), Validators.required]],
			username: ["", [Validators.maxLength(32), Validators.required]],
		});
		this.status = {status: null, message: null, type: null}
	}
	createSignIn() : void {
		let signUp : SignIn = {profileAvatarUrl : "http://kittens.photo", profileEmail : this.signInForm.value.email, profileFirstName : this.signUpForm.value.firstName, profileLastName : this.signUpForm.value.lastName, profilePassword : this.signUpForm.value.password, profilePasswordConfirm : this.signUpForm.value.passwordConfirm, profileUsername : this.signUpForm.value.username};
		this.signInService.createProfile(signUp).subscribe(status=> {
			this.status = status;

			if(this.status.status === 200){
				alert(status.message);

			}
		})
	}


}
