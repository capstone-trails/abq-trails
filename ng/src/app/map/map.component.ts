import {Component, OnInit} from "@angular/core";
import {MapService} from "ngx-mapbox-gl";
import  {TrailService} from "../shared/services/trail.service";
import {Trail} from "../shared/interfaces/trail";
import {Router} from "@angular/router";

@Component({
	templateUrl:"./map.component.html",
	styleUrls: ["./map.component.css"],
	selector: "map"
})

export class MapComponent implements OnInit {

	map: any;
	lat: number = 35.0856181;
	lng: number = -106.6493357;

	trails: Trail[] = [];


	constructor(private mapService: MapService, private trailService: TrailService, private router: Router)
	{}

	ngOnInit(): void {
		this.getAllTrails();

	}


	goToTrail(trail: Trail): void {
		this.router.navigate(["/trail-detail/", trail.trailId]);
	}


	getAllTrails (): void {
		this.trailService.getAllTrails().subscribe(trail => {
			this.trails= trail;
		})
	}
}
