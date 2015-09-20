<?php

namespace App\CoreBundle\Form;

use App\CoreBundle\Model\RelatedPersonModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SelectRelatedPersonFormType extends AbstractType
{
    /** @var  PersonChoiceLoader  */
    protected $choiceLoader;

    /**
     * @param PersonChoiceLoader $choiceLoader
     */
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
            ->add('personFrom', 'choice', [
                'choices' => $this->choiceLoader->getChoices(),
            ])
            ->add('personTo', 'choice', [
                'choices' => $this->choiceLoader->getChoices(),
            ])
            ->add('orm', 'submit', ['label' => 'Use ORM'])
            ->add('ogm', 'submit', ['label' => 'Use OGM']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => RelatedPersonModel::class]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'related';
    }
}
