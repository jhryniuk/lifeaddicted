import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Event} from "../interfaces/event";

@Injectable({
  providedIn: 'root'
})
export class EventService {

  private httpOptions = {
    headers: new HttpHeaders({
      'Accept':  'application/json',
    })
  };

  constructor(
    private http: HttpClient
  ) {
  }

  public getEventList() {
    return this.http.get("http://lifeaddicted.local/event", this.httpOptions);
  }

  public getEvent(eventId: number) {
    return this.http.get('http://lifeaddicted.local/event/' + eventId, this.httpOptions);
  }

  public put(eventId: number, data: Event) {
    console.log(data);
    return this.http.put('test', data);
  }
}
