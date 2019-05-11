import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Event} from "../interfaces/event";
import {environment} from '../environments/environment';
import * as moment from "moment";
import {ParticipantService} from "./participant.service";

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
    let participantsIds = [];
    data.participants.forEach((p) =>{
      participantsIds.push(p.id);
    });

    let toPersist = {
      name: data.name,
      eventDate: moment(data.event_date).format('YYYY-MM-DD HH:mm:ss'),
      owner: data.owner[0].id,
      participants: participantsIds,
    };

    return this.http.put(environment.api_url + '/event/' + eventId, toPersist, this.httpOptions);
  }
}
