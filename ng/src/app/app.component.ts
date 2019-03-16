import { Component } from '@angular/core';
import { SessionService } from "./shared/services/session.services";
import  { Status } from "./shared/interfaces/status";

// import { MapService } from "ngx-mapbox-gl";
// import { faPaw } from "@fortawesome/free-solid-svg-icons";


@Component({
  selector: 'app-root',
	templateUrl: './app.component.html',
})


export class AppComponent {

	status : Status = null;

	constructor(protected sessionService : SessionService) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}



}
