
import {Component, OnInit, ViewChild,} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../shared/interfaces/status"
import {SignUp} from "../shared/interfaces/sign-up";
import {SignUpService} from "../shared/services/sign-up.service";

@Component({
	templateUrl:"./sign-up.component.html",
	selector: "sign-up"
})

//set template URL and the selector for the ng powered html

export class SignUpComponent implements OnInit{


	signUpForm : FormGroup;
	status : Status = {status: null, message: null, type: null};

	constructor(private formBuilder : FormBuilder, private signUpService : SignUpService){
	}

	ngOnInit() : void {
		this.signUpForm = this.formBuilder.group({
			avatarUrl : ["", [Validators.maxLength(255)]],
			email: ["", [Validators.maxLength(128), Validators.required, Validators.email]],
			firstName: ["", [Validators.maxLength(32), Validators.required]],
			lastName: ["", [Validators.maxLength(32), Validators.required]],
			password: ["", [Validators.maxLength(128), Validators.minLength(8), Validators.required]],
			passwordConfirm: ["", [Validators.maxLength(128), Validators.minLength(8), Validators.required]],
			username: ["", [Validators.maxLength(32), Validators.required]],
		});
		this.status = {status: null, message: null, type: null}
	}
	createSignUp() : void {
		let signUp : SignUp = {profileAvatarUrl : "http://kittens.photo", profileEmail : this.signUpForm.value.email, profileFirstName : this.signUpForm.value.firstName, profileLastName : this.signUpForm.value.lastName, profilePassword : this.signUpForm.value.password, profilePasswordConfirm : this.signUpForm.value.passwordConfirm, profileUsername : this.signUpForm.value.username};
		this.signUpService.createProfile(signUp).subscribe(status=> {
			this.status = status;

			if(this.status.status === 200){
				alert(status.message);

			}
		})
	}


}
