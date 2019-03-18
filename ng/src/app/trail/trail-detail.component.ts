import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";
import {Trailtag} from "../shared/interfaces/trailtag";

import {RatingService} from "../shared/services/rating.service";
import {TrailService} from "../shared/services/trail.service";
import {AuthService} from "../shared/services/auth-service";
import {SessionService} from "../shared/services/session.services";



@Component({
	templateUrl: "./trail-detail.component.html",
	styleUrls: ["./trail-detail.component.css"],
	selector: "trail-detail"
})


export class TrailDetailComponent implements OnInit {

	trail : Trail = {
		id: "0acd1043-aea9-4eb9-9e14-245b3c45c1e3",
		trailAvatarUrl: null,
		trailDescription: null,
		trailHigh: null,
		trailLatitude: null,
		trailLength: null,
		trailLongitude: null,
		trailLow: null,
		trailName: null
	};


	rating : Rating = {ratingProfileId: null, ratingTrailId: null, ratingDifficulty: null, ratingValue: null};

	ratings : Rating[] = [];

	trailtag : Trailtag = {trailTagTagId: null, trailTagTrailId: null};

	trailtags : Trailtag[] = [];

	status : Status = null;

	tempId: string = this.authService.decodeJwt().auth.profileId;

	constructor(private trailService: TrailService, private authService: AuthService, private ratingService: RatingService, private sessionService: SessionService) {
	}


	ngOnInit(): void {
		this.getTrailById(this.trail.id);
		this.sessionService.setSession();
		this.trailService.getTrailById(this.trail.id).subscribe(reply => this.trail = reply);
		this.ratingService.getRatingByTrailId(this.rating.ratingTrailId).subscribe(reply => this.rating = reply);
	}

	getTrailById(id: string): void {
		this.trailService.getTrailById(id)
			.subscribe(trail =>
				this.trail = trail
			);
	}

	getJwtProfileId() : any {
		if(this.authService.decodeJwt()) {
			return this.authService.decodeJwt().auth.profileId;
		} else {
			return false
		}
	}

	createRating() : any {
		if(!this.getJwtProfileId()) {
			return false
		}

		let newRatingProfileId = this.getJwtProfileId();

		rating: Rating = {ratingProfileId: null, ratingTrailId: null, ratingDifficulty: null, ratingValue: this.createRating()};

		this.ratingService.createRating(rating)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.rating.reset();
				} else {
					return false
				}
			})
	}

}