import { Component, OnInit, OnDestroy, ChangeDetectorRef, ElementRef } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import { ManufacturerService } from '../manufacturer.service';
import { ModelService } from '../model.service';
import { ImageService } from '../image.service';

@Component({
  selector: 'app-model',
  templateUrl: './model.component.html',
  styleUrls: ['./model.component.css']
})
export class ModelComponent implements OnInit {

  modelForm: FormGroup;
  submitted = false;
  errorArr = [];
  successArr = [];
  picture_temp_name = "";
  yearsArray: number[];

  fileExtensionError = false;
  fileExtensionMessage = "";

  fileToUpload: File;

  manufacturers$: Object;

  constructor(private formBuilder: FormBuilder, private manufacturer: ManufacturerService, private model: ModelService, private image: ImageService, private changeDetectorRef: ChangeDetectorRef, private elRef:ElementRef) {
    this.yearsArray = [2010,2011,2012,2013,2014,2015,2016,2017,2018];
  }

  ngOnInit() {
    this.modelForm = this.formBuilder.group({
      model_name: ['', [Validators.required, Validators.maxLength(190)]],
      color_name: ['', [Validators.required, Validators.maxLength(190)]],
      manufacturer_year: ['', Validators.required],
      registration_number: ['', [Validators.required, Validators.maxLength(190)]],
      note: ['', Validators.maxLength(190)],
      manufacturer: ['', Validators.required],
      picture_one: [''],
      picture_two: ['']
    });

    this.manufacturer.getManufacturers().subscribe(
      data => {

        if( data["success"] )
        {
          this.manufacturers$ = data["success"];
        }

        if( data["error"] )
        {
          // this.error = true;
        }

      }
    );

  }

  get f(){
    return this.modelForm.controls;
  }

  onSubmit(){
    this.submitted = true;

    this.successArr = [];
    this.errorArr = [];

    if( this.modelForm.invalid ){
      return;
    }

    let formValue = this.modelForm.value;

    let modl_name = formValue["model_name"];
    let color_name = formValue["color_name"];
    let manufacturer_year = formValue["manufacturer_year"];
    let registration_no = formValue["registration_number"];
    let manufacturer = formValue["manufacturer"];
    let note = formValue["note"] ? formValue["note"] : "";
    let picture_one = "";
    let picture_two = "";

    let picture_1 = this.elRef.nativeElement.querySelector('#picture_one');
    let picture_2 = this.elRef.nativeElement.querySelector('#picture_two');

    if(picture_1.files && picture_1.files.length) 
    {    
      if( this.fileExtensionError )
      {
        this.errorArr.push(this.fileExtensionMessage);
        return;
      }
      else
      {
        picture_one = this.createdImageName();
      }
    }

    if(picture_2.files && picture_2.files.length)
    {    
      if( this.fileExtensionError )
      {
        this.errorArr.push(this.fileExtensionMessage);
        return;
      }
      else
      {
        picture_two = this.createdImageName();
      }
    }

    this.model.addModel( JSON.stringify( { name : modl_name, color: color_name, year: manufacturer_year, registration_no: registration_no, note:note, picture_one:picture_one, picture_two:picture_two, manufacturer:manufacturer } ) ).subscribe(
      data => {

        if( data["success"] )
        {

          if(picture_1.files && picture_1.files.length) 
          {    
            if( ! this.fileExtensionError )
            {
              let reader = new FileReader();
              this.readFile(picture_1.files[0], reader, ()=>{}, picture_one);
            }
          }
      
          if(picture_2.files && picture_2.files.length)
          {    
            if( ! this.fileExtensionError )
            {
              let reader = new FileReader();
              this.readFile(picture_2.files[0], reader, ()=>{}, picture_two);
            }
          }

          this.successArr.push(data["success"]);
          this.modelForm.reset();
          this.submitted = false;
        }

        if( data["error"] )
        {
          this.errorArr.push(data["error"]);
        }
      }
    );

  }

  onFileChange(event) {

    let reader = new FileReader();
   
    if(event.target.files && event.target.files.length) {

      let file = event.target.files[0];
      let fileName = file.name;
      let allowedExtensions = 
       ["jpg","jpeg","png","JPG","JPEG","JFIF","BMP","SVG"];
      let fileExtension = fileName.split('.').pop();

      if(this.isInArray(allowedExtensions, fileExtension)) {
          this.fileExtensionError = false;
          this.fileExtensionMessage = "";
      } else {
          this.fileExtensionMessage = "Only .jpg, .jpeg, .png, .bmp, .svg, .jfif formats are supported!";
          this.fileExtensionError = true;
      }

    }

    // this.readFiles(event.target.files );
    
  }

  readFile(file, reader, callback, tempName = ""){

    reader.onload = () => {
      callback(reader.result);
      this.fileToUpload = reader.result;
      this.onImageUpload(tempName);
    }
    reader.readAsDataURL(file);
  }

  readFiles(files, index=0){


    let reader = new FileReader();
    if (index in files) {
      this.readFile(files[index], reader, (result) => {
        var img = document.createElement("img");
        img.src = result;
  
        this.readFiles(files, index+1);
      });
    } else {
      this.changeDetectorRef.detectChanges();

    }
  }
  
  onImageUpload(tempName = "") {

    if( !tempName )
    {
      tempName = this.createdImageName();
    }

    this.image.updateImage( this.fileToUpload, tempName).subscribe(
      (photo: any) => {
        if (photo) { 
          // photo
        }
      }
    );

  }

  /*- checks if word exists in array -*/
  isInArray(array, word) {
    return array.indexOf(word.toLowerCase()) > -1;
  }

  createdImageName() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-";
  
    for (var i = 0; i < 25; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return text;
  }
  

}
