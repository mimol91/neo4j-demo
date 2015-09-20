<?php

namespace App\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PersonType extends AbstractType
{
    /** @var  PersonChoiceLoader  */
    protected $choiceLoader;

    public function __construct(PersonChoiceLoader $choiceLoader)
    {
        $this->choiceLoader = $choiceLoader;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName')
            ->add('friends', 'choice', [
                'multiple' => true,
                'required' => false,
                'choices' => $this->choiceLoader->getChoices(),
             ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'person';
    }
}
