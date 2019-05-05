import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {EventService} from "../../services/event.service";
import {Event} from "../../interfaces/event";
import {NgForm} from "@angular/forms";
import {EventRaw} from "../../interfaces/event-raw";
import {EventRawToEvent} from "../../dto/EventRawToEvent";

@Component({
  selector: 'app-event',
  templateUrl: './event.component.html',
  styleUrls: ['./event.component.scss']
})
export class EventComponent implements OnInit {
  private id: number;
  private event: Event;
  private eventList: Array<Event> = [];
  private error: string;

  public constructor(
    private route: ActivatedRoute,
    private eventService: EventService
  ) {
    this.id = parseInt(this.route.snapshot.paramMap.get('id'), 10);
  }

  public ngOnInit() {
    if (this.id) {
      this.eventService.getEvent(this.id)
        .subscribe(
          (data: EventRaw) => {
            let dto = new EventRawToEvent();
            this.event = dto.transform(data);
          },
          (error) => this.error = error.toString()
        );
    } else {
      this.eventService.getEventList()
        .subscribe(
          (data: Array<EventRaw>) => (data.forEach((d) => {
            let dto = new EventRawToEvent();
            this.eventList.push(dto.transform(d));
          })),
          (error) => this.error = error.toString()
        );
    }
  }


  public onSubmit(form: NgForm) {
    console.log(form);
  }
}
