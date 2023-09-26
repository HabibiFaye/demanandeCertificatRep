<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LieuReception',ChoiceType::class,array(
                'choices' => array(
                    'Liste des Commissariats disponibles ' => 'liste',
                    'Commissariat central de Dakar' => 'Dakar',
                    'Commissariat du Plateau' => 'Plateau',
                    'Commissariat de Rebeuss'=> 'Rebeuss',
                    'Commissariat de Medina'=> 'Medina',
                    'Commissariat de Dieupeul'=> 'Dieupeul')))
           // ->add('created_at')
          //  ->add('statutDemande')
          //  ->add('statut')
          //  ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
