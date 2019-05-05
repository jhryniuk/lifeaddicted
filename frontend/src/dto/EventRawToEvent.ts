import {Event} from "../interfaces/event"
import {EventRaw} from "../interfaces/event-raw";

export class EventRawToEvent {
  public transform(eventRaw: EventRaw): Event {

    let date = new Date(eventRaw.event_date);

    return {
      id: eventRaw.id,
      name: eventRaw.name,
      event_date: date,
      owner: eventRaw.owner,
      participants: eventRaw.participants
    }
  }
}
