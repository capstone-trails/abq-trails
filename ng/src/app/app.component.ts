import { Component } from '@angular/core';
import { SessionService } from "./shared/services/session.services";
import  { Status } from "./shared/interfaces/status";

// import { MapService } from "ngx-mapbox-gl";
// import { faPaw } from "@fortawesome/free-solid-svg-icons";


@Component({
  selector: 'app-root',
	templateUrl: './app.component.html',
	styles: [`
		mgl-map {
			height: 80vh;
			width: 80vw;
		}
		mgl-marker {
			width: 15px;
			height: 15px;
			border-radius: 50%;
			background-color: red;
		}
	`],
})


export class AppComponent {

	status : Status = null;

	// Geo
	// map: any;
	// lat: number = 35.0856181;
	// lng: number = -106.6493357;
	// fawPaw = faPaw;
	//
	//
	// points: any = [
	// 	{name: "one", lng: -106.6495457, lat: 35.0356181},
	// 	{name: "two", lng: -106.6503457, lat: 35.0556161},
	// 	{name: "three", lng: -106.6513557, lat: 35.0756131},
	// 	{name: "two", lng: -106.6493757, lat: 35.0956141},
	// ];

	constructor(protected sessionService : SessionService) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}



}
