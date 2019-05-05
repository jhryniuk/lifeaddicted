import {User} from "./user";
import {Participant} from "./participant";

export interface Event {
  id: number,
  name: string,
  event_date: Date
  owner: Array<User>,
  participants: Array<Participant>
}
