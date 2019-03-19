import {Component, OnInit, ViewChild} from "@angular/core";
import {Observable} from 'rxjs';
import {debounceTime, distinctUntilChanged, filter, map} from 'rxjs/operators';
import {Router} from "@angular/router";
import {TrailService} from "../shared/services/trail.service";
import {Trail} from "../shared/interfaces/trail";


const trails = ["test", "best", "vest", "rest"];


@Component({
	templateUrl: "./search.component.html",
	styleUrls: ["./search.component.css"],
	selector: "search"
})



export class SearchComponent {

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

	public model: any;

	search = (text$: Observable<string>) =>
		text$.pipe(
			debounceTime(200),
			distinctUntilChanged(),
			map(term => term.length < 2 ? []
				: trails.filter(v => v.toLowerCase().indexOf(term.toLowerCase()) > -1).slice(0, 10))
		);

	constructor( private trailService: TrailService) {
	}

	getTrailByName(trailName: string) : void {
		this.trailService.getTrailsByName(trailName).subscribe(trail => {
			this.trails = trail;
		})
	}
}