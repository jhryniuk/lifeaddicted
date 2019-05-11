<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Participant::class);
    }
    public function findAll()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->getQuery()->getResult();
    }

    public function findById(int $id)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()->getResult();
    }
}
