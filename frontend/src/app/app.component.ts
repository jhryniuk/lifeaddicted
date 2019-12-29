import {Component} from '@angular/core';
import {TranslateService} from "@ngx-translate/core";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  public constructor(private translate: TranslateService) {
    translate.setDefaultLang('en');
  }

  public setLanguage(language: string) {
    this.translate.use(language);
  }

  title = 'Life Addicted';
}
