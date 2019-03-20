import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {Trail} from "../shared/interfaces/trail";
import {Rating} from "../shared/interfaces/rating";
import {Trailtag} from "../shared/interfaces/trailtag";

import {MapService} from "ngx-mapbox-gl";
import {RatingService} from "../shared/services/rating.service";
import {TrailService} from "../shared/services/trail.service";
import {AuthService} from "../shared/services/auth-service";
import {SessionService} from "../shared/services/session.services";
import {ProfileService} from "../shared/services/profile.service";
import {ActivatedRoute} from "@angular/router";

import {Photo} from "../shared/interfaces/photo";
import {PhotoService} from "../shared/services/photo.service";
import {FileUploader} from "ng2-file-upload";
import {CookieService} from "ngx-cookie";



@Component({
	templateUrl: "./trail-detail.component.html",
	styleUrls: ["./trail-detail.component.css"],
	selector: "trail-detail"
})



export class TrailDetailComponent implements OnInit {

	map: any;
	// lat: number = 35.0856181;
	// lng: number = -106.6493357;

	photo: Photo = {
		id: null,
		photoProfileId: null,
		photoTrailId: null,
		cloudinaryResult: null,
		photoDateTime: null,
		photoUrl: null
	};

	public uploader: FileUploader = new FileUploader(
		{
			itemAlias: 'photo',
			url: './api/photo/',
			headers: [
				//you will alos want to include a JWT-TOKEN
				{name: 'X-XSRF-TOKEN', value: this.cookieService.get('XSRF-TOKEN')}
			],
		}
	);

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
		private cookieService: CookieService,
		private photoService: PhotoService) {
	}

	ngOnInit(): void {
		this.getTrailById(this.id);
		this.sessionService.setSession();
		this.trailService.getTrailById(this.trail.trailId);
		//this.createRating();
		this.ratingService.getRatingByProfileIdAndTrailId(this.rating.ratingProfileId, this.rating.ratingTrailId);
		// this.ratingService.getRatingByProfileId(this.tempId);
		// this.ratingService.getRatingByProfileId(this.rating.ratingProfileId);
		this.ratingService.getRatingByTrailId(this.rating.ratingTrailId);
	}

	getTrailById(id: string): void {
		this.trailService.getTrailById(id)
			.subscribe(trail =>
				this.trail = trail
			);
	}

	uploadPhoto(): void {
		console.log(this.uploader);
		this.uploader.uploadAll();
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





