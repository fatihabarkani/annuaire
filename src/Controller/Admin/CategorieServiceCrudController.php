<?php

namespace App\Controller\Admin;

use App\Entity\CategorieService;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class CategorieServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieService::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('nom'),
            TextField::new('description'),
            BooleanField::new('enAvant'),
            BooleanField::new('valide'),
            AssociationField::new('images'),
        ];
    }
    
}
