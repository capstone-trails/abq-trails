import { NgModule } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from "@angular/forms";
import { JwtModule } from "@auth0/angular-jwt";
import { allAppComponents, appRoutingProviders, routing } from "./app.routes.module";
import { AppComponent } from './app.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import {UpdateProfileComponent} from "./profile/update-profile/update-profile.component";
import {NgxMapboxGLModule} from "ngx-mapbox-gl";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";
import {MapComponent} from "./map/map.component";
import {CookieModule} from "ngx-cookie";
import { FileUploadModule } from 'ng2-file-upload';



let mapBoxConfig = NgxMapboxGLModule.withConfig({accessToken: "pk.eyJ1IjoiY3JvbWVybzI3OCIsImEiOiJjanRjMmY0dWswczV2M3lucmljdzZqMm95In0.z7Io2Wm8GbfFpepbUmjUwQ"});

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
	imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, JwtHelper, NgbModule, mapBoxConfig, FontAwesomeModule, CookieModule.forRoot(), FileUploadModule],
	declarations: [ ...allAppComponents, AppComponent, MapComponent],
	entryComponents: [UpdateProfileComponent],
	bootstrap:    [ AppComponent ],
	providers:    [ appRoutingProviders],

})

export class AppModule { }
