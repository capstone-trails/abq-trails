import {Component, OnInit} from "@angular/core";
import {MapService} from "ngx-mapbox-gl";
import {faPaw} from "@fortawesome/fontawesome-free-solid";

@Component({
	templateUrl:"./map.component.html"

})

export class MapComponent {
	faPaw : faPaw;

	constructor(private mapService: MapService)
	{}
}
