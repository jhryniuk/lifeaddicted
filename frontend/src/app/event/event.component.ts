import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {EventService} from "../../services/event.service";
import {Event} from "../../interfaces/event";
import {NgForm} from "@angular/forms";
import {EventRaw} from "../../interfaces/event-raw";
import {EventRawToEvent} from "../../dto/EventRawToEvent";
import {ParticipantService} from "../../services/participant.service";
import {Participant} from "../../interfaces/participant";

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
  private existingParticipant: Participant;

  public constructor(
    private route: ActivatedRoute,
    private eventService: EventService,
    private participantService: ParticipantService
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
    let event = this.event;
    this.participantService.getByEmail(form.value.email)
      .subscribe(
        (data: Participant) => {
          this.existingParticipant = data;
        },
        () => {
          this.existingParticipant = null;
          this.participantService.createParticipant(
            {
              firstName: form.value.firstName,
              lastName: form.value.lastName,
              email: form.value.email,
              mobile: form.value.mobile
            }
          )
            .subscribe((data: Participant) => {
              event.participants.push(data);
              this.eventService.put(this.id, event)
                .subscribe();
            });
        }
      );
  }

  private submitExistingParticipant(data: Participant, form: NgForm)
  {
    form.reset();
    this.event.participants.push(data);
    this.eventService.put(this.id, this.event).subscribe();
    this.existingParticipant = null;
  }

  private submitNewParticipant(form: NgForm)
  {
    this.participantService.createParticipant(
      {
        firstName: form.value.firstName,
        lastName: form.value.lastName,
        email: form.value.email,
        mobile: form.value.mobile
      }
    )
      .subscribe((data: Participant) => {
        this.event.participants.push(data);
        this.eventService.put(this.id, this.event)
          .subscribe();
      });

    form.reset();
    this.existingParticipant = null;
  }
}
