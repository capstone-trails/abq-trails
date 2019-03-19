import { Component } from '@angular/core';
import {SessionService} from "./shared/services/session.services";
import  {Status} from "./shared/interfaces/status";
import {SignInService} from "./shared/services/sign-in.service";
import {Router} from "@angular/router";


@Component({
  selector: 'app-root',
	templateUrl: './app.component.html',
})


export class AppComponent {

	status : Status = null;

	constructor(private sessionService : SessionService, private signInService: SignInService, private router: Router) {
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


}
