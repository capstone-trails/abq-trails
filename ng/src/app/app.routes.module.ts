import {RouterModule, Routes} from "@angular/router";

import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/interceptor";

import {SessionService} from "./shared/services/session.services";
import {AuthService} from "./shared/services/auth-service";
import {ProfileService} from "./shared/services/profile.service";
import {RatingService} from "./shared/services/rating.service";
import {SignInService} from "./shared/services/sign-in.service";
import {SignUpService} from "./shared/services/sign-up.service";
import {TagService} from "./shared/services/tag.service";
import {TrailtagService} from "./shared/services/trailtag.service";
import {TrailService} from "./shared/services/trail.service";

import {ProfileComponent} from "./profile/profile.component";
import {SignInComponent} from "./sign-in/sign-in.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {UpdateProfileComponent} from "./profile/update-profile/update-profile.component";
import {TrailComponent} from "./trail/trail.component";
import {TrailDetailComponent} from "./trail/trail-detail.component";


import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component";
import {MapComponent} from "ngx-mapbox-gl";





export const allAppComponents = [AppComponent, SignUpComponent, SignInComponent, ProfileComponent, UpdateProfileComponent, TrailComponent, TrailDetailComponent, MapComponent, SplashComponent];

export const routes: Routes = [
	{path: "sign-up", component: SignUpComponent},
	{path: "sign-in", component: SignInComponent},
	{path: "profile", component: ProfileComponent},
	{path: "trail", component: TrailComponent},
	{path: "trail-detail", component: TrailDetailComponent},
	{path: "map", component: MapComponent},
	{path: "", component: SplashComponent}

];

export const appRoutingProviders: any[] = [
	ProfileService, RatingService, SignInService, SignUpService, TagService, TrailtagService, TrailService, SessionService, AuthService,
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];

export const routing = RouterModule.forRoot(routes);