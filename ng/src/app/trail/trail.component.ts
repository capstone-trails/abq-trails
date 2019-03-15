import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {TrailService} from "../shared/services/trail.service";
import {Router} from "@angular/router";

@Component({
	templateUrl: "./trail.component.html",
})


export class TrailComponent implements OnInit {


	trail: Trail = {id: null, trailAvatarUrl: null, trailDescription: null, trailHigh: null, trailLatitude: null, trailLength: null, trailLongitude: null, trailLow:null, trailName:null};

	trails: Trail[] = [];

	status: Status = null;




	constructor(protected trailService: TrailService, private router : Router) {
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
}