import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Event} from "../interfaces/event";
import {environment} from '../environments/environment'

@Injectable({
  providedIn: 'root'
})
export class EventService {

  private httpOptions = {
    headers: new HttpHeaders({
      'Accept': 'application/json'
    })
  };

  constructor(
    private http: HttpClient
  ) {
  }

  public getEventList() {
    return this.http.get(environment.api_url + "/event", this.httpOptions);
  }

  public getEvent(eventId: number) {
    return this.http.get(environment.api_url + '/event/' + eventId, this.httpOptions);
  }

  public put(eventId: number, data: Event) {
    return this.http.put(environment.api_url + '/event/' + eventId, data, this.httpOptions);
  }
}
