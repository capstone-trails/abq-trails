import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import {ReactiveFormsModule} from "@angular/forms";
import {JwtModule} from "@auth0/angular-jwt";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes.module";
import { AppComponent } from './app.component';


const JwtHelper = JwtModule.forRoot({
	config: {
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
	imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, JwtHelper],
	declarations: [ ...allAppComponents, AppComponent],
	bootstrap:    [ AppComponent ],
	providers:    [appRoutingProviders]
})
export class AppModule { }
