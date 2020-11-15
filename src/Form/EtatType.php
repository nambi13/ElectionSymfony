<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Reference')
            ->add('nbrevoie')
            ->add('Pays',EntityType::class,[
                'class' => Pays::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'nompays',


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etat::class,
        ]);
    }
}
