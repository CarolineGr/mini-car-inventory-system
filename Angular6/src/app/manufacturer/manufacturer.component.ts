import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import { ManufacturerService } from '../manufacturer.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-manufacturer',
  templateUrl: './manufacturer.component.html',
  styleUrls: ['./manufacturer.component.css']
})
export class ManufacturerComponent implements OnInit {

  manufacturerForm: FormGroup;
  submitted = false;
  success = false;
  error = false;
  errorArr = [];
  successArr = [];
  msgs: any[];

  manufacturers$: Object;

  constructor(private formBuilder: FormBuilder, private manufacturer: ManufacturerService) {
    this.msgs = [];
  }

  ngOnInit() {
    this.manufacturerForm = this.formBuilder.group({
      manufacturer_name: ['', [Validators.required, Validators.maxLength(190)]]
    });

    this.manufacturer.getManufacturers().subscribe(
      data => {

        if( data["success"] )
        {
          this.manufacturers$ = data["success"];
        }

        if( data["error"] )
        {
          this.error = true;
        }

      }
    );

  }

  get f(){
    return this.manufacturerForm.controls;
  }

  onSubmit(){
    this.submitted = true;

    this.successArr = [];
    this.errorArr = [];

    if( this.manufacturerForm.invalid ){
      return;
    }

    let formValue = this.manufacturerForm.value;

    let manufacturer_name = formValue["manufacturer_name"];

    this.manufacturer.addManufacturer( JSON.stringify( { name : manufacturer_name } ) ).subscribe(
      data => {

        if( data["success"] )
        {
          this.successArr.push(data["success"]);
          this.manufacturerForm.reset();
          this.submitted = false;
        }

        if( data["error"] )
        {
          this.errorArr.push(data["error"]);
        }
      }
    );

  }

}