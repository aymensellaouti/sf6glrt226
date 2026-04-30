<?php

namespace App\Form;

use App\Entity\Identifier;
use App\Entity\Person;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('age')
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'designation',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('identifier', EntityType::class, [
                'class' => Identifier::class,
                'choice_label' => function (Identifier $identifier) {
                    return $identifier->getName()." ".$identifier->getValue();
                },
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
