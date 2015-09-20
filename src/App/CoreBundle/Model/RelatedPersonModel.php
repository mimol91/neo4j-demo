<?php

namespace App\CoreBundle\Model;

use App\CoreBundle\Entity\Person;

class RelatedPersonModel
{
    /** @var Person  */
    protected $personFrom;

    /** @var Person  */
    protected $personTo;

    /**
     * @return Person
     */
    public function getPersonFrom()
    {
        return $this->personFrom;
    }

    /**
     * @param Person $personFrom
     */
    public function setPersonFrom($personFrom)
    {
        $this->personFrom = $personFrom;
    }

    /**
     * @return Person
     */
    public function getPersonTo()
    {
        return $this->personTo;
    }

    /**
     * @param Person $personTo
     */
    public function setPersonTo($personTo)
    {
        $this->personTo = $personTo;
    }
}
