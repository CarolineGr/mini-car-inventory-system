import { Component, OnInit, ElementRef } from '@angular/core';
import { ActivatedRoute } from "@angular/router";

import { InventoryService } from '../inventory.service';

@Component({
  selector: 'app-inventory',
  templateUrl: './inventory.component.html',
  styleUrls: ['./inventory.component.css']
})
export class InventoryComponent implements OnInit {

  errorArr = [];
  successArr = [];
  contentErrorArr = [];
  error = false;
  soldDisabled = false;

  inventories$: Object;
  inventoriesByManufacturerAndModel$: Object;
  manufacturer$: Object;
  model$: Object;

  constructor(private inventory: InventoryService,private route: ActivatedRoute, private elRef:ElementRef) {}

  ngOnInit() {

    this.route.params.subscribe(params => {
      this.manufacturer$ = this.route.snapshot.params.manufacturer;
      this.model$ = this.route.snapshot.params.model;
    });

    if( this.manufacturer$ && this.model$ )
    {

      this.inventory.getInventoriesByManufacturerAndModel(this.manufacturer$, this.model$).subscribe(
        data => {

          if( data["success"] )
          {
            this.inventoriesByManufacturerAndModel$ = data["success"];
          }
  
          if( data["error"] )
          {
            this.contentErrorArr = data["error"];
          }
  
        }
      );
    }

    this.inventory.getInventories().subscribe(
      data => {

        if( data["success"] )
        {
          this.inventories$ = data["success"];
        }

        if( data["error"] )
        {
          this.contentErrorArr = data["error"];
        }

      }
    );

  }

  onSold(id)
  {

    if(id)
    {

      let close = this.elRef.nativeElement.querySelector('#close_' + id);
      
      this.soldDisabled = true;

      this.successArr = [];
      this.errorArr = [];

      this.inventory.deleteModel( JSON.stringify( { id : id} ) ).subscribe(
        data => {

          if( data["success"] )
          {
            close.click();

            this.inventoriesByManufacturerAndModel$ = "";
            this.ngOnInit();
            this.successArr.push(data["success"]);
          }

          if( data["error"] )
          {
            this.errorArr.push(data["error"]);
          }
        }
      );

      this.soldDisabled = false;

    }

  }

}
