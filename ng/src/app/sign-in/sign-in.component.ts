
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../shared/interfaces/status"
import {SignIn} from "../shared/interfaces/sign-in";
import {SignInService} from "../shared/services/sign-in.service";
import {SessionService} from "../shared/services/session.services";


@Component({
	templateUrl: "./sign-in.component.html",
	selector: "sign-in"
})


export class SignInComponent implements OnInit {

	signInForm : FormGroup;
	signIn : SignIn = {profileEmail: null, profilePassword: null};
	status : Status = null;

	constructor(
		private formBuilder : FormBuilder,
		private router : Router,
		private signInService : SignInService,
		private sessionService : SessionService
	) {}

	ngOnInit() : void {
		this.signInForm = this.formBuilder.group({
				profileEmail: ["", [Validators.maxLength(128), Validators.required]],
				profilePassword: ["", [Validators.maxLength(32), Validators.required]]
			}
		);
		this.applyFormChanges();
	}

	applyFormChanges() : void {
		this.signInForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.signIn [field] = values[field];
			}
		});
	}

	submitSignIn(): void {
		window.localStorage.clear();
		this.signInService.postSignIn(this.signIn)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					this.sessionService.setSession();
					this.signInForm.reset();
					location.reload();

					this.router.navigate(["/profile"]);
				}
			});
	}
	signOut() : void {
		this.signInService.getSignOut();
	}

}