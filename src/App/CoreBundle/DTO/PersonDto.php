<?php

namespace App\CoreBundle\DTO;

use App\CoreBundle\Entity\Person;
use HireVoice\Neo4j\Repository;

class PersonDto
{
    /** @var Person */
    private $person;

    /** @var Repository */
    protected $repository;

    /**
     * @param Person     $person
     * @param Repository $repository
     */
    public function __construct(Person $person, Repository $repository)
    {
        $this->person = $person;
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->person->getFullName();
    }

    /**
     * @return array
     */
    public function getFriends()
    {
        return $this->person->getFriends()->map(function (Person $person) {
            return $person->getId();
        })->toArray();
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setFullName($name)
    {
        return $this->person->setFullName($name);
    }

    /**
     * @param Person $person
     *
     * @return $this
     */
    public function addFriend(Person $person)
    {
        return $this->person->addFriend($person);
    }

    /**
     * @param array $friendsId
     *
     * @return $this
     */
    public function setFriends($friendsId)
    {
        $friends = array_map(function ($friendId) {
            return $this->repository->find($friendId);
        }, $friendsId);

        return $this->person->setFriends($friends);
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}
