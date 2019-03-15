import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {TrailService} from "../shared/services/trail.service";
import {Rating} from "../shared/interfaces/rating";

@Component({
	templateUrl: "./trail.component.html",
})


export class TrailComponent implements OnInit {

	rating : Rating = {ratingProfileId: null, ratingTrailId: null};

	trail: Trail = {id: null, trailAvatarUrl: null, trailDescription: null, trailHigh: null, trailLatitude: null, trailLength: null, trailLongitude: null, trailLow:null, trailName:null};

	trails: Trail[] = [];

	status: Status = null;




	constructor(protected trailService: TrailService) {
	}

	ngOnInit(): void {
		this.getAllTrails();
	}

	getAllTrails (): void {

		this.trailService.getAllTrails()
			.subscribe(trail => {
				this.trails= trail;

			});

	}

	getTrailById(id: string): void {

		this.trailService.getTrailById(id)
			.subscribe(trail=>
				this.trail= trail
		);
	}
}