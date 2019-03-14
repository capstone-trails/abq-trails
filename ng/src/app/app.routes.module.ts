import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {ProfileService} from "./shared/services/profile.service";
import {RatingService} from "./shared/services/rating.service";
import {SignInService} from "./shared/services/sign-in.service";
import {SignUpService} from "./shared/services/sign-up.service";
import {TagService} from "./shared/services/tag.service";
import {TrailtagService} from "./shared/services/trailtag.service";
import {TrailService} from "./shared/services/trail.service";
import {SessionService} from "./shared/services/session.services";
import {SignInComponent} from "./sign-in/sign-in.component";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/interceptor";
import {AuthService} from "./shared/services/auth-service";


export const allAppComponents = [AppComponent, SignUpComponent, SignInComponent, SplashComponent];

export const routes: Routes = [
	{path: "sign-up", component: SignUpComponent},
	{path: "sign-in", component: SignInComponent},
	{path: "", component: SplashComponent}

];

export const appRoutingProviders: any[] = [
	ProfileService, RatingService, SignInService, SignUpService, TagService, TrailtagService, TrailService, SessionService, AuthService,
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];

export const routing = RouterModule.forRoot(routes);