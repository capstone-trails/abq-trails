import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";

import {MapService} from "ngx-mapbox-gl";
import {RatingService} from "../shared/services/rating.service";
import {TrailService} from "../shared/services/trail.service";
import {AuthService} from "../shared/services/auth-service";
import {SessionService} from "../shared/services/session.services";
import {ProfileService} from "../shared/services/profile.service";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {NgbRatingConfig} from '@ng-bootstrap/ng-bootstrap';
import {ActivatedRoute} from "@angular/router";

import {PhotoComponent} from "./photo/photo.component";




@Component({
	templateUrl: "./trail-detail.component.html",
	styleUrls: ["./trail-detail.component.css"],
	selector: "trail-detail",
	styles: [`    .star {
		font-size: 1.5rem;
		color: rgba(0, 140, 125, 0.51);
	}
	.filled {
		color: #008c7d;
	}
	`]
})



export class TrailDetailComponent implements OnInit {

	map: any;
	// lat: number = 35.0856181;
	// lng: number = -106.6493357;


	trails: Trail[] = [];

	trail : Trail = {
		trailId: null,
		trailAvatarUrl: null,
		trailDescription: null,
		trailHigh: null,
		trailLatitude: null,
		trailLength: null,
		trailLongitude: null,
		trailLow: null,
		trailName: null
	};

	id = this.activatedRoute.snapshot.params["id"];

	rating : Rating = {ratingProfileId: null, ratingTrailId: null, ratingDifficulty: 2, ratingValue: 5};

	status : Status = null;

	// tempId: string = this.authService.decodeJwt().auth.profileId;

	constructor(
		private trailService: TrailService,
		private authService: AuthService,
		private ratingService: RatingService,
		private sessionService: SessionService,
		private profileService: ProfileService,
		private activatedRoute: ActivatedRoute,
		private mapSerivce: MapService,
		private modalService: NgbModal,
		private config: NgbRatingConfig,
	) {
		config.max = 5;
		config.readonly = true;
	}

	ngOnInit(): void {
		this.getTrailById(this.id);
		this.sessionService.setSession();
		this.trailService.getTrailById(this.trail.trailId);
		this.ratingService.getRatingByRatingProfileIdAndRatingTrailId(this.rating.ratingProfileId, this.rating.ratingTrailId);
		this.ratingService.getRatingByRatingTrailId(this.rating.ratingTrailId);
	}

	getTrailById(id: string): void {
		this.trailService.getTrailById(id)
			.subscribe(trail =>
				this.trail = trail
			);
	}

	getRatingByRatingTrailId(ratingTrailId: string): void {
		this.ratingService.getRatingByRatingTrailId(this.rating.ratingTrailId);
	}

	openUploadPhotoModal() {
		this.modalService.open(PhotoComponent);
	}


}

	/**
	 * TODOs

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

	 **/





