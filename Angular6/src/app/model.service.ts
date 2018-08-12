import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ModelService {

  constructor(private http: HttpClient) { }

  getModels() {
    return this.http.get('http://localhost/minicar/api/manufacturer/get.php')
  }

  addModel(data){
    return this.http.post('http://localhost/minicar/api/model/create.php', data );
  }

}
