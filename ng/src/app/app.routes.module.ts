import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component"

import {APP_BASE_HREF} from "@angular/common";
import {SignUpComponent} from "./sign-up/sign-up.component";


export const allAppComponents = [AppComponent, SignUpComponent, SplashComponent];

export const routes: Routes = [
	{path: "sign-up", component: SignUpComponent},
	{path: "", component: SplashComponent}

];

export const appRoutingProviders: any[] = [
];

export const routing = RouterModule.forRoot(routes);