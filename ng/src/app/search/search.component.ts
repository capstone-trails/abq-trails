import {Component, OnInit, ViewChild} from "@angular/core";
import {Observable} from 'rxjs';
import {debounceTime, distinctUntilChanged, filter, map} from 'rxjs/operators';
import {Router} from "@angular/router";
import {TrailService} from "../shared/services/trail.service";
import {Trail} from "../shared/interfaces/trail";


const trails = ["La Luz", "Elena Gallegos", "Copper Trailhead", "10K Trailhead", "Tree Springs", "Bosque River"];

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
				: trails.filter(trails => trails.toLowerCase().indexOf(term.toLowerCase()) > -1).slice(0, 10))
		);

	constructor( private trailService: TrailService) {
	}


	getAllTrails(): void {
		this.trailService.getAllTrails().subscribe(trail => {
			this.trails= trail;
		})
	}

	getTrailByName(trailName: string) : void {
		this.trailService.getTrailsByName(trailName).subscribe(trail => {
			this.trails = trail;
		})
	}
}