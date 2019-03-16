import { NgModule } from '@angular/core';
import { HttpClientModule } from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from "@angular/forms";
import { JwtModule } from "@auth0/angular-jwt";
import { allAppComponents, appRoutingProviders, routing } from "./app.routes.module";
import { AppComponent } from './app.component'



/* MAP BOX STUFF */
import { MapService, NgxMapboxGLModule } from "ngx-mapbox-gl";
import { FontAwesomeModule } from "@fortawesome/angular-fontawesome";

let ngxMapboxConfig = NgxMapboxGLModule.withConfig({
	accessToken: 'pk.eyJ1IjoiZ2Vvcmdla2VwaGFydCIsImEiOiJjanQ4cmdmYjkwYnZnNDNwNDF4NXFiMTJmIn0.MwDDiyszR0QFmMYMNvzi1Q',
});



const JwtHelper = JwtModule.forRoot({
	config : {
		tokenGetter: () => {
			return localStorage.getItem("jwt-token");
		},
		skipWhenExpired: true,
		whitelistedDomains: ["localhost:7272", "https:bootcamp-coders.cnm.edu/"],
		headerName: "X-JWT-TOKEN",
		authScheme: ""
	}
});

@NgModule({
	imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, JwtHelper, ngxMapboxConfig, FontAwesomeModule, ],
	declarations: [ ...allAppComponents, AppComponent],
	bootstrap:    [ AppComponent ],
	providers:    [ appRoutingProviders, MapService, ],
})

export class AppModule { }
