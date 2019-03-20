import { Component } from '@angular/core';
import {SessionService} from "./shared/services/session.services";
import  {Status} from "./shared/interfaces/status";
import {SignInService} from "./shared/services/sign-in.service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import {Router} from "@angular/router";
import {SignInComponent} from "./sign-in/sign-in.component";
import {AuthService} from "./shared/services/auth-service";



@Component({
  selector: 'app-root',
	templateUrl: './app.component.html',
})


export class AppComponent {

	isLoggedIn: boolean;

	status : Status = null;

	constructor(private authService : AuthService, private sessionService : SessionService, private signInService: SignInService, private router: Router, private modalService: NgbModal) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
		this.isLoggedIn = this.authService.loggedIn();
	}

	signOut() : void {
		this.signInService.getSignOut().subscribe( reply => reply );
		window.localStorage.clear();
		location.reload();
		this.router.navigate([""]);
		alert("You have signed out!");
	}

	openSignInModal() {
		this.modalService.open(SignInComponent);
	}


}
