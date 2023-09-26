<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',options:['label' => 'Nom *'])
        ->add('prenom',options:['label' => 'Prenom *'])
        ->add('dateNaissance',BirthdayType::class, options:['label' => 'Date de Naissace *'])
        ->add('CIN',options:['label' => 'Numero Carte d\'identité Nationale '])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            
        ]);
    }
}
