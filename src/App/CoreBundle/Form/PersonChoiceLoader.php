<?php

namespace App\CoreBundle\Form;

use App\CoreBundle\Entity\Person;
use HireVoice\Neo4j\EntityManager;

class PersonChoiceLoader
{
    /** @var  EntityManager  */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getChoices()
    {
        $choices = [];
        $elements = $this->em->getRepository(Person::class)->findAll();
        foreach ($elements as $element) {
            $choices[$element->getId()] = $element->getFullName();
        }

        asort($choices);

        return $choices;
    }
}
