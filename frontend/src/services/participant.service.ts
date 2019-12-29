import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {environment} from '../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ParticipantService {

  private httpOptions = {
    headers: new HttpHeaders({
      'Accept': 'application/json'
    })
  };

  constructor(
    private http: HttpClient
  ) {
  }

  public getByEmail(email: string) {
    return this.http.get(environment.api_url + '/participant-by-email/' + email, this.httpOptions);
  }

  public createParticipant(data) {
    return this.http.post(environment.api_url + '/participant', data, this.httpOptions);
  }
}
