import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";
import {Trailtag} from "../shared/interfaces/trailtag";

import {TrailService} from "../shared/services/trail.service";



@Component({
	templateUrl: "./trail-detail.component.html",
	styleUrls: [""],
	selector: "trail-detail"
})


export class TrailDetailComponent implements OnInit {

	trail : Trail = {
		id: null,
		trailAvatarUrl: null,
		trailDescription: null,
		trailHigh: null,
		trailLatitude: null,
		trailLength: null,
		trailLongitude: null,
		trailLow: null,
		trailName: null
	};


	rating : Rating = {ratingProfileId: null, ratingTrailId: null};

	trailtag : Trailtag = {trailTagTagId: null, trailTagTrailId: null};

	trailtags : Trailtag[] = [];

	status : Status = null;


	constructor(protected trailService: TrailService) {
	}


	ngOnInit(): void {
		this.getTrailById(this.trail.id);
	}

	getTrailById(id: string): void {
		this.trailService.getTrailById(id)
			.subscribe(trail =>
				this.trail = trail
			);
	}


}