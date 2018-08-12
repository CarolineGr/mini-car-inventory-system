import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ManufacturerComponent } from './manufacturer/manufacturer.component';
import { ModelComponent } from './model/model.component';
import { InventoryComponent } from './inventory/inventory.component';
import { HomeComponent } from './home/home.component';
import { NotfoundComponent } from './notfound/notfound.component';
import { AppComponent } from './app.component';

const routes: Routes = [
  // {
  //   path: '',
  //   component: AppComponent
  // },
  { 
    path: '', 
    redirectTo: 'home', 
    pathMatch: 'full' 
  },
  {
    path: 'home',
    component: HomeComponent
  },
  {
    path: 'manufacturer',
    component: ManufacturerComponent
  },
  {
    path: 'model',
    component: ModelComponent
  },
  {
    path: 'inventory/manufacturer/:manufacturer/model/:model',
    component: InventoryComponent
  },
  {
    path: 'inventory',
    component: InventoryComponent
  },
  {
    path: '**',
    component: NotfoundComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
