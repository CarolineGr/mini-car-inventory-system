import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import {Observable} from 'rxjs/Rx';

@Injectable({
  providedIn: 'root'
})
export class ImageService {

  config = {
    "host": "http://localhost/minicar/api/image/upload.php"
  };

  constructor(private http: HttpClient) { }

  updateImage(fileToUpload, imageName){
    
    const body = JSON.stringify( { name: imageName, image: fileToUpload } );
    // const headers = new Headers({ 'Content-Type': 'image/jpeg' });

    console.log(body);

    return this.http.patch(this.config.host, body)
    .map((response: Response) => {
      console.log(response);
    })
    .catch((error: Response) => {
      console.log("Error: ", error);
      return Observable.throw(error);
    });

  }

}
