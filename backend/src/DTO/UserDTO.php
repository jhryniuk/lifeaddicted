<?php declare(strict_types=1);

namespace App\DTO;

use App\Entity\User;

class UserDTO implements DTO
{
    /**
     * @var User
     */
    private $user;

    public function set(User $user)
    {
        $this->user = $user;
    }

    public function toArray(): ?array
    {
        $user = [
            'id' => $this->user->getId(),
            'firstName' => $this->user->getFirstName(),
            'lastName' => $this->user->getLastName(),
            'email' => $this->user->getEmail(),
        ];
        return $user;
    }

    public function toObject(): User
    {
        return $this->user;
    }
}