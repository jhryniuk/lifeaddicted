<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    private $firstName;
    private $lastName;
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function __toString()
    {
        return "$this->firstName $this->lastName";
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event)
    {
        if (! $this->events->contains($event)) {
            $this->events->add($event);
        }
    }

    public function removeEvent(Event $event)
    {
        $this->events->removeElement($event);
    }
}