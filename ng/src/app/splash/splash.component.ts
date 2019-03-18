import {Component, OnInit} from "@angular/core";
import {MapService} from "ngx-mapbox-gl";
import  {TrailService} from "../shared/services/trail.service";
import {Trail} from "../shared/interfaces/trail";
import {SignInService} from "../shared/services/sign-in.service";
import {Router} from "@angular/router";

@Component({
	templateUrl:"./splash.component.html",
})

export class SplashComponent implements OnInit {



	constructor(private signInService: SignInService, private router: Router)
	{}

	ngOnInit(): void {
	}


	signOut() : void {
		this.signInService.getSignOut();
		window.localStorage.clear();
		location.reload();
		this.router.navigate(["/map"]);
		alert("You have signed out!");
	}


	}
