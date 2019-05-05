<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Event
{
    private $id;
    private $name;
    private $owner;
    private $participants;
    private $eventDate;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->owner = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function addOwner(User $owner): void
    {
        if (!$this->owner->contains($owner)) {
            $this->owner->clear();
            $this->owner->add($owner);
        }
    }

    public function removeOwner(User $owner)
    {
        if ($this->owner->contains($owner)) {
            $this->owner->removeElement($owner);
        }
    }

    /**
     * @return Collection
     */
    public function getParticipants() : Collection
    {
        return $this->participants;
    }

    /**
     * @param Participant $participant
     */
    public function addParticipant(Participant $participant): void
    {
        if (! $this->participants->contains($participant)) {
            $this->participants->add($participant);
        }
    }

    public function clearParticipant(): void
    {
        $this->participants->clear();
    }

    public function removeParticipant(Participant $participant)
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
        }
    }

    /**
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param \DateTime $eventDate
     */
    public function setEventDate($eventDate): void
    {
        $this->eventDate = $eventDate;
    }
}