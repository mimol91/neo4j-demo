<?php

namespace App\CoreBundle\Services\FriendRelation;

use App\CoreBundle\Entity\Person;
use Doctrine\Common\Collections\ArrayCollection;
use SplObjectStorage;
use Symfony\Component\Config\Definition\Exception\Exception;

class SQLRelation
{
    /** @var int  */
    protected $level = 0;

    /** @var array */
    protected $result = [];

    /** @var array  */
    protected $processedIds = [];

    /** @var Person[] */
    protected $currentElements = [];

    /**
     * @param Person $personFrom
     * @param Person $personTo
     *
     * @return array
     */
    public function getRelationPath(Person $personFrom, Person $personTo)
    {
        if ($this->areEquals($personFrom, $personTo)) {
            return [$personFrom];
        }

        if ($this->areClosestFriends($personFrom, $personTo)) {
            return [$personFrom, $personTo];
        }

        $relationArray = $this->getRelation($personFrom, $personTo);

        return array_reverse($relationArray);
    }

    /**
     * @param Person $personFrom
     * @param Person $personTo
     *
     * @return bool
     */
    protected function areEquals(Person $personFrom, Person $personTo)
    {
        return $personFrom->getId() === $personTo->getId();
    }

    /**
     * @param Person $personFrom
     * @param Person $personTo
     *
     * @return bool
     */
    protected function areClosestFriends(Person $personFrom, Person $personTo)
    {
        return in_array($personTo->getId(), $this->getUsersId($personFrom->getFriends()->toArray()));
    }

    /**
     * @param Person $personFrom
     * @param Person $personTo
     *
     * @return array
     */
    protected function getRelation(Person $personFrom, Person $personTo)
    {
        $this->initZeroLevel($personFrom);
        try {
            $this->generateMap($personTo);
        } catch (Exception $e) {
            throw $e;
        }

        return array_merge($this->processBackward($personTo), [$personFrom]);
    }

    /**
     * @param Person $personTo
     *
     * @throws \Exception
     */
    protected function generateMap(Person $personTo)
    {
        do {
            ++$this->level;
            $this->processLevel();
            if (in_array($personTo->getId(), $this->processedIds)) {
                return;
            }
        } while (count(end($this->result)));

        throw new \Exception('Relation does not exist');
    }

    /**
     * @param Person $personFrom
     */
    protected function initZeroLevel(Person $personFrom)
    {
        $this->currentElements = [$personFrom];
        $this->result[0] = [$personFrom->getId()];
        $this->processedIds = array_unique(array_merge($this->processedIds, $this->result[0]));
    }

    /**
     * @return array
     */
    protected function processLevel()
    {
        $friends = $this->getAllFriends();

        $this->currentElements = $friends->toArray();
        $this->result[$this->level] = $this->getUsersId($this->currentElements);
        $this->processedIds = array_unique(array_merge($this->processedIds, $this->result[$this->level]));
    }

    /**
     * @return ArrayCollection
     */
    protected function getAllFriends()
    {
        $friends = new SplObjectStorage();
        foreach ($this->currentElements as $currentElement) {
            foreach ($currentElement->getFriends() as $friend) {
                if (!$friends->contains($friend)) {
                    $friends->attach($friend);
                }
            }
        }

        return (new ArrayCollection(iterator_to_array($friends)))->filter(function (Person $friend) {
            return !in_array($friend->getId(), $this->processedIds);
        });
    }

    /**
     * @param Person $personTo
     *
     * @return array
     */
    protected function processBackward(Person $personTo)
    {
        $result = [$personTo];
        $this->result = array_reverse($this->result);

        for ($i = 1; $i < $this->level; ++$i) {
            $result[] = $result[$i-1]->getFriends()->filter(function (Person $person) use ($i) {
                return in_array($person->getId(), $this->result[$i]);
            })->first();
        }

        return $result;
    }

    /**
     * @param Person[] $users
     *
     * @return array
     */
    protected function getUsersId(array $users)
    {
        return array_values(array_map(function (Person $person) {
            return $person->getId();
        }, $users));
    }
}
