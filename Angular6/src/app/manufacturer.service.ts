import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ManufacturerService {

  constructor(private http: HttpClient) { }

  getManufacturers() {
    return this.http.get('http://localhost/minicar/api/manufacturer/get.php')
  }

  addManufacturer(data){
    return this.http.post('http://localhost/minicar/api/manufacturer/create.php', data );
  }

}
