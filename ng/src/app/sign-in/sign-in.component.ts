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

	signIn() : void {
		localStorage.removeItem("jwt-token");
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;
		});
	}

}
