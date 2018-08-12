import { Component, OnInit } from '@angular/core';
import { Router, NavigationEnd } from '@angular/router';
import { ActivatedRoute, UrlSegment } from '@angular/router';

@Component({
  selector: 'body',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {

  currentUrl: string = "";

  title = 'minicar';

  constructor(private router:Router) {

    router.events.subscribe(event => {
      if (event instanceof NavigationEnd ) {
        if( event.url )
        {
          this.currentUrl = event.url;
        }
      }
    });
  }

  ngOnInit() {
  }

}
