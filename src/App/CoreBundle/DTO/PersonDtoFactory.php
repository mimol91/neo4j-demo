<?php

namespace App\CoreBundle\DTO;

use App\CoreBundle\Entity\Person;
use HireVoice\Neo4j\EntityManager;
use HireVoice\Neo4j\Repository;

class PersonDtoFactory
{
    /** @var Repository */
    private $repository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(Person::class);
    }

    /**
     * @param Person $person
     *
     * @return PersonDto
     */
    public function getPersonDto(Person $person)
    {
        return new PersonDto($person, $this->repository);
    }
}
