<?php declare(strict_types=1);

namespace App\DTO;

use App\Entity\Participant;

class ParticipantDTO implements DTO
{
    /**
     * @var Participant
     */
    private $participant;

    public function set(Participant $user)
    {
        $this->participant = $user;
    }

    public function toArray(): ?array
    {
        $participant = [
            'id' => $this->participant->getId(),
            'firstName' => $this->participant->getFirstName(),
            'lastName' => $this->participant->getLastName(),
            'email' => $this->participant->getEmail(),
            'mobile' => $this->participant->getMobile(),
        ];
        return $participant;
    }

    public function toObject(): Participant
    {
        return $this->participant;
    }
}