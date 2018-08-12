import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class InventoryService {

  constructor(private http: HttpClient) { }

  getInventories() {
    return this.http.get('http://localhost/minicar/api/inventory/get.php')
  }

  getInventoriesByManufacturerAndModel(manufacturer_id, model_name) {
      return this.http.get('http://localhost/minicar/api/inventory/filter-by-manufacturer-model.php?manufacturer='+manufacturer_id+'&model='+model_name)
  }

  deleteModel(data){
    return this.http.post('http://localhost/minicar/api/model/delete.php', data );
  }

}
