import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Event} from "../interfaces/event";
import {environment} from '../environments/environment'
import * as moment from "moment";

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
    let toPersist = {
      name: data.name,
      eventDate: moment(data.event_date).format('YYYY-MM-DD HH:mm:ss'),
      owner: data.owner[0].id,
      participants: [1,2],
    };
    // data.participants.forEach((p, v) => {
    //   toPersist.participants[v] = p.id;
    // });
    return this.http.put(environment.api_url + '/event/' + eventId, toPersist, this.httpOptions);
  }
}
