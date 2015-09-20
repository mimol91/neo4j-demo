<?php

namespace App\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use HireVoice\Neo4j\Annotation as OGM;

/**
 * @OGM\Entity(labels="Person")
 */
class Person
{
    /**
     * @OGM\Auto
     */
    protected $id;

    /**
     * @OGM\Property
     * @OGM\Index
     */
    protected $fullName;

    /**
     * @OGM\ManyToMany(relation="KNOWS")
     *
     * @var ArrayCollection
     */
    protected $friends;

    public function __construct()
    {
        $this->friends = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     *
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param Person[] $friends
     *
     * @return $this
     */
    public function setFriends($friends)
    {
        foreach ($friends as $friend) {
            $this->addFriend($friend);
        }

        return $this;
    }

    /**
     * @param Person $friend
     *
     * @return $this
     */
    public function addFriend(Person $friend)
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        if (!$friend->getFriends()->contains($this)) {
            $friend->getFriends()->add($this);
        }

        return $this;
    }
}
