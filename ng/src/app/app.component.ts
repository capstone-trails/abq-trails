import { Component } from '@angular/core';
import {SessionService} from "./shared/services/session.services";
import  {Status} from "./shared/interfaces/status";
import {SignInService} from "./shared/services/sign-in.service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import {Router} from "@angular/router";
import {SignInComponent} from "./sign-in/sign-in.component";

import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";


@Component({
  selector: 'app-root',
	templateUrl: './app.component.html',
})


export class AppComponent {

	status : Status = null;

	constructor(private sessionService : SessionService, private signInService: SignInService, private router: Router, private modalService: NgbModal) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}

	signOut() : void {
		this.signInService.getSignOut();
		window.localStorage.clear();
		location.reload();
		this.router.navigate([""]);
		alert("You have signed out!");
	}

	openSignInModal() {
		this.modalService.open(SignInComponent);
	}


}
