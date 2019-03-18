import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";
import {Trailtag} from "../shared/interfaces/trailtag";

import {TrailService} from "../shared/services/trail.service";


@Component({
	templateUrl: "./trail.component.html",
	styleUrls: ["./trail.component.css"],
	selector: "trails"
})


export class TrailComponent implements OnInit {

	trail: Trail = {
		id: null,
		trailAvatarUrl: null,
		trailDescription: null,
		trailHigh: null,
		trailLatitude: null,
		trailLength: null,
		trailLongitude: null,
		trailLow:null,
		trailName:null
	};

	trails: Trail[] = [];

	// rating : Rating = {ratingProfileId: null, ratingTrailId: null};

	trailtag : Trailtag = {trailTagTagId: null, trailTagTrailId: null};

	status: Status = null;


	constructor(private router: Router, private trailService: TrailService) {
	}


	ngOnInit(): void {
		this.getAllTrails();
		this.getTrailByName(this.trail.trailName);
	}

	getAllTrails(): void {
		this.trailService.getAllTrails().subscribe(trail => {
			this.trails= trail;
		})
	}


	getTrailByName(trailName: string) : void {
		this.trailService.getTrailsByName(trailName).subscribe(trail => {
			this.trails = trail;
		})
	}



	getDetailedTrailView(trail : Trail) : void {
		this.router.navigate(["/trail-detail/", trail.id]);
	}


}