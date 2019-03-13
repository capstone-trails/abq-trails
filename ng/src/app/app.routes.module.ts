import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component"

import {APP_BASE_HREF} from "@angular/common";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {ProfileService} from "./shared/services/profile.service";
import {RatingService} from "./shared/services/rating.service";
import {SignInService} from "./shared/services/sign-in.service";
import {SignUpService} from "./shared/services/sign-up.service";
import {TagService} from "./shared/services/tag.service";
import {TrailtagService} from "./shared/services/trailtag.service";
import {TrailService} from "./shared/services/trail.service";


export const allAppComponents = [AppComponent, SignUpComponent, SplashComponent];

export const routes: Routes = [
	{path: "sign-up", component: SignUpComponent},
	{path: "", component: SplashComponent}

];

export const appRoutingProviders: any[] = [ProfileService, RatingService, SignInService, SignUpService, TagService, TrailtagService, TrailService
];

export const routing = RouterModule.forRoot(routes);