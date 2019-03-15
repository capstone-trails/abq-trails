import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {TrailService} from "../shared/services/trail.service";
import {AuthService} from "../shared/services/auth-service";
import {JwtModule} from "@auth0/angular-jwt";

@Component({
	templateUrl: "./trail.component.html",
})


export class TrailComponent implements OnInit {

	profile: Trail = {
		id: null,
		trailAvatarUrl: null,
		trailDescription: null,
		trailHigh: null,
		trailLow: null,
		trailLatitude: null,
		trailLength: null,
		trailLongitude: null,
		trailLow: null,
		trailName: null,
	};

	status: Status = null;


	tempId: string = this.authService.decodeJwt().auth.trailId;


	constructor(protected profileService: TrailService, private authService: AuthService) {
	}


	ngOnInit(): void {
		this.getTrail();
	}

	getTrail (): void {
		//for testing
		this.trailService.getTrailsByName(this.tempId)
			.subscribe(trail => this.trail = trail);

		//live
		// 	this.profileService.getProfile(this.profileId)
		// 		.subscribe(profile => this.profile = profile);
		// }
	}
}