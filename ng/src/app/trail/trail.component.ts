import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";
import {Trailtag} from "../shared/interfaces/trailtag";
import {NgbRatingConfig} from '@ng-bootstrap/ng-bootstrap';

import {TrailService} from "../shared/services/trail.service";


@Component({
	templateUrl: "./trail.component.html",
	styleUrls: ["./trail.component.css"],
	selector: "trails",
	styles: [`    .star {
		font-size: 1.5rem;
		color: rgba(0, 140, 125, 0.51);
	}

	.filled {
		color: #008c7d;
	}
	`]
})


export class TrailComponent implements OnInit {

	trail: Trail = {
		trailId: null,
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

	rating : Rating = {ratingProfileId: null, ratingTrailId: null, ratingDifficulty: 2, ratingValue: 5};

	status: Status = null;


	constructor(
		private router: Router,
		private trailService: TrailService,
		private config: NgbRatingConfig,
	) {
	config.max = 5;
	config.readonly = true;
	}


	ngOnInit(): void {
		this.getAllTrails();
		this.getTrailByName(this.trail.trailName);
	}

	getAllTrails(): void {
		this.trailService.getAllTrails().subscribe(trail  => {
			this.trails= trail;
		})
	}


	getTrailByName(trailName: string) : void {
		this.trailService.getTrailsByName(trailName).subscribe(trail => {
			this.trails = trail;
		})
	}


	getDetailedTrailView(trail: Trail) : void {
		this.router.navigate(["/trail-detail/", trail.trailId]);
	}


}