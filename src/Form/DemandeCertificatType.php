<?php

namespace App\Form;

use App\Entity\DemandeCertificat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DemandeCertificatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Lieu_reception_certificat',ChoiceType::class,array(
                'choices' => array(
                    'Liste des Commissariats disponibles ' => 'liste',
                    'Commissariat central de Dakar' => 'Dakar',
                    'Commissariat du Plateau' => 'Plateau',
                    'Commissariat de Rebeuss'=> 'Rebeuss',
                    'Commissariat de Medina'=> 'Medina',
                    'Commissariat de Dieupeul'=> 'Dieupeul'),
                ))
          //  ->add('created_at')
            ->add('Prenom')
            ->add('Nom')
            ->add('numeroTelephone')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeCertificat::class,
        ]);
    }
}
