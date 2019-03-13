/*
 this component is for signing up to use the site.
 */

//import needed modules for the sign-up component
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status"
import {Profile} from "../shared/interfaces/profile";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	templateUrl:"./update-profile.component.html"
})

//set template URL and the selector for the ng powered html

export class UpdateProfileComponent implements OnInit {

	updateProfileForm : FormGroup;
	status: Status = {status: null, message: null, type: null};

	constructor(private formBuilder : FormBuilder, private profileService : ProfileService){
	}

	ngOnInit() : void {
	}
	}