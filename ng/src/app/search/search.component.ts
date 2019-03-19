import {Component, OnInit, ViewChild} from "@angular/core";
import {Observable} from 'rxjs';
import {debounceTime, distinctUntilChanged, filter, map} from 'rxjs/operators';
import {Router} from "@angular/router";
import {TrailService} from "../shared/services/trail.service";
import {Trail} from "../shared/interfaces/trail";


@Component({
	templateUrl: "./search.component.html",
	styleUrls: ["./search.component.css"],
	selector: "search"
})


export class SearchComponent {

	trails: Trail[] = [];

	public model: any;

	search = (text$: Observable<string>) =>
		text$.pipe(
			debounceTime(200),
			distinctUntilChanged(),
			map(term => term.length < 2 ? []
				: this.trails.filter(trail => trail.trailName.toLowerCase().indexOf(term.toLowerCase()) > -1).slice(0, 10))
		);

	constructor( private trailService: TrailService) {
	}


	getTrailByName(event) : void {
		if(event.key === "Enter") {
		this.trailService.getTrailsByName(this.model).subscribe(trail => {
			this.trails = trail;
		})
		}
	}
}