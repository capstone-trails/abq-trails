/*
 this component is for signing up to use the site.
 */

//import needed modules for the sign-up component
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Observable} from "rxjs/internal/Observable";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status"
import {SignUp} from "../shared/interfaces/sign-up";
// import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUpService} from "../shared/services/sign-up.service";

declare let $: any;

@Component({
	template:("./sign-up.component.html")
})

//set template URL and the selector for the ng powered html

export class SignUpComponent implements OnInit{

	signUpForm : FormGroup;

	signUp: SignUp
}
