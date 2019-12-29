import {User} from "./user";
import {Participant} from "./participant";

export interface EventRaw {
  id: number,
  name: string,
  event_date: string,
  owner: Array<User>,
  participants: Array<Participant>
}
