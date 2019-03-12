import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import {allAppComponents, appRoutingProviders, routing} from "./app.routes.module"
import { AppComponent } from './app.component';


@NgModule({
	imports:      [ BrowserModule, FormsModule , routing],
	declarations: [ ...allAppComponents, AppComponent],
	bootstrap:    [ AppComponent ]
})
export class AppModule { }
