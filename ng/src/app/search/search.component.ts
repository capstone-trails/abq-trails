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



	public model: any;

	search = (text$: Observable<string>) =>
		text$.pipe(
			debounceTime(200),
			distinctUntilChanged(),
			map(term => term.length < 2 ? []
				: this.trails.filter(trail => trail.trailName.toLowerCase().indexOf(term.toLowerCase()) > -1).slice(0, 10))
		);


	constructor( private trailService: TrailService, private router: Router) {
	}

	formatter = (result: Trail) => {
		if(result !== undefined) {
			console.log(result);
			return(result.trailName.toUpperCase());
		}
	};


	searchTrailByName(event: any) : void {
		// if(event.key === "Enter") {
		// 	this.trailService.searchTrailsByName(this.model).subscribe(trail => {
		// 		this.trails = trail;
		// 	})
		// }
		this.trailService.searchTrailsByName(this.model).subscribe(trail => {
			this.trails = trail;
		})
	}

	// getTrailById(event: any, id: string): void {
	// 	if(event.key === "Enter") {
	// 		this.trailService.getTrailById(this.model)
	// 			.subscribe(trail =>
	// 				this.trail = trail
	// 		);
	// 	}
	// }

	getDetailedTrailView(event: any) : void {
		if(event.keypress === "Enter") {
			this.router.navigate(["/trail-detail/", this.trail.trailId]);
		}
	}

}