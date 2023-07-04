<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Entity\DemandeCertificat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class DemandeCertificatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DemandeCertificat::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnIndex(),
            TextField::new('Prenom'),
            TextField::new('Nom'),
            TextField::new('Lieu_reception_certificat'),
            TextField::new('user'),
            DateTimeField::new('created_at'),
            BooleanField::new('statut_demande'),
            
        ];
    }
    
}
