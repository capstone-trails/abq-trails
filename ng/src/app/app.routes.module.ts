import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component"

import {APP_BASE_HREF} from "@angular/common";


export const allAppComponents = [AppComponent, SplashComponent];

export const routes: Routes = [
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [
];

export const routing = RouterModule.forRoot(routes);