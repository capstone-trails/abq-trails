import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {AuthService} from "../shared/services/auth-service";
import {JwtModule} from "@auth0/angular-jwt";


@Component({
	templateUrl: "./profile.component.html",
})


export class ProfileComponent implements OnInit{

	profile : Profile = {id:null, profileAvatarUrl:null, profileEmail:null, profileFirstName:null, profileLastName:null, profilePassword:null, profilePasswordConfirm: null, profileUsername:null};

	status: Status = null;

	authService : AuthService;

	constructor(protected profileService: ProfileService, authService : AuthService) {}


	ngOnInit():void {
	}

	getProfileId() : string {
		if(this.authService.decodeJwt()) {
			return this.authService.decodeJwt().auth.profileId;
		} else {
			return ''
		}
	}

	getProfileByProfileId(id : string) : void {
		this.profileService.getProfileByProfileId(id).subscribe(reply => {
			this.profile = reply;
		})

	}



}



