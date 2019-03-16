import {Component, OnInit} from "@angular/core";
import {MapService} from "ngx-mapbox-gl";
import  {TrailService} from "../shared/services/trail.service";
import {Trail} from "../shared/interfaces/trail";

@Component({
	templateUrl:"./map.component.html",
})

export class MapComponent implements OnInit {

	map: any;
	lat: number = 35.0856181;
	lng: number = -106.6493357;

	trails: Trail[] = [];


	constructor(private mapService: MapService, private trailService: TrailService)
	{}

	ngOnInit(): void {
		this.getAllTrails();

	}
	getAllTrails (): void {
		this.trailService.getAllTrails().subscribe(trail => {
			this.trails= trail;
		})
	}
}
