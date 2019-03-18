import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";
import {Trailtag} from "../shared/interfaces/trailtag";

import {RatingService} from "../shared/services/rating.service";
import {TrailService} from "../shared/services/trail.service";
import {AuthService} from "../shared/services/auth-service";
import {SessionService} from "../shared/services/session.services";
import {ProfileService} from "../shared/services/profile.service";
import {ActivatedRoute} from "@angular/router";



@Component({
	templateUrl: "./trail-detail.component.html",
	styleUrls: ["./trail-detail.component.css"],
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

	trailId = this.activatedRoute.snapshot.params["trailId"];

	rating : Rating = {ratingProfileId: null, ratingTrailId: null, ratingDifficulty: 2, ratingValue: 5};

	status : Status = null;

	// tempId: string = this.authService.decodeJwt().auth.profileId;

	constructor(private trailService: TrailService, private authService: AuthService, private ratingService: RatingService, private sessionService: SessionService, private profileService: ProfileService, private activatedRoute: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.getTrailById(this.trailId);
		this.sessionService.setSession();
		this.trailService.getTrailByTrailId(this.trail.id);
		//this.createRating();
		this.ratingService.getRatingByProfileIdAndTrailId(this.rating.ratingProfileId, this.rating.ratingTrailId);
		// this.ratingService.getRatingByProfileId(this.tempId);
		// this.ratingService.getRatingByProfileId(this.rating.ratingProfileId);
		this.ratingService.getRatingByTrailId(this.rating.ratingTrailId);
	}


	getTrailById(id: string): void {
		this.trailService.getTrailByTrailId(id)
			.subscribe(trail =>
				this.trail = trail
			);
	}


	createRating(): void {

		let rating: Rating;

		this.ratingService.createRating(rating)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					alert(this.status.message);
				}
			});
	}


	getRatingByProfileIdAndTrailId(): void {
		this.ratingService.getRatingByProfileIdAndTrailId(this.rating.ratingProfileId, this.rating.ratingTrailId).subscribe(rating => this.rating = rating);
	}


	getRatingByTrailId(): void {
		this.ratingService.getRatingByTrailId(this.rating.ratingTrailId);
	}





}

