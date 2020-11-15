<?php

namespace App\Form;
use App\Entity\Etat;
use App\Entity\Votant;
use App\Entity\Election;
use App\Entity\President;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VotantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre')
            ->add('Etat',EntityType::class,[
                'class' => Etat::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'reference',


            ])
            ->add('Election',EntityType::class,[
                'class' => Election::class,

                // uses the User.username property as the visible option string
                'choice_label' => function ($election) {
                    return $election->StringtoDates();
                }


            ])
            ->add('President',EntityType::class,[
                'class' => President::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'nom',


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Votant::class,
        ]);
    }
}
