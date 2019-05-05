<?php declare(strict_types=1);

namespace App\DTO;

use App\Entity\Event;
use App\Entity\Participant;

class EventDTO implements DTO
{
    /**
     * @var Event
     */
    private $event;

    public function set(Event $event)
    {
        $this->event = $event;
    }

    public function toArray(): ?array
    {
        $participants = [];
        $owners = [];

        foreach ($this->event->getOwner() as $owner) {
            $user = new UserDTO();
            $user->set($owner);

            $owners[] = $user->toArray();
        }

        foreach ($this->event->getParticipants() as $participant) {
            $user = new ParticipantDTO();
            $user->set($participant);

            $participants[] = $user->toArray();
        }

        return $event = [
            'id' => $this->event->getId(),
            'name' => $this->event->getName(),
            'event_date' => $this->event->getEventDate()->format(DATE_ATOM),
            'participants' => $participants,
            'owner' => $owners,
        ];
    }

    public function toObject()
    {
        return $this->event;
    }
}