import {Component, OnInit} from "@angular/core";
import {ActivatedRoute} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";


@Component({
	templateUrl: "./profile.component.html",
})


export class ProfileComponent implements OnInit{
	profile : Profile = {id:null,profileAvatarUrl:null,profileEmail:null,profileFirstName:null,profileLastName:null,profileUsername:null};

	status: Status = null;


	constructor(protected profileService: ProfileService, private route: ActivatedRoute) {}


	ngOnInit():void {
		let id = this.route.snapshot.params["id"];
		this.getProfileByProfileId(id);
	}

	getProfileByProfileId(id : string) : void {
		this.profileService.getProfileByProfileId(id).subscribe(reply => {
			reply.profile = this.profile;
		})
	}



}