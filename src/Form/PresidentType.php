<?php

namespace App\Form;

use App\Entity\President;
use App\Entity\Election;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Election',EntityType::class,[
                'class' => Election::class,

                // uses the User.username property as the visible option string
                'choice_label' => function ($election) {
                    return $election->StringtoDates();
                }


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => President::class,
        ]);
    }
}
