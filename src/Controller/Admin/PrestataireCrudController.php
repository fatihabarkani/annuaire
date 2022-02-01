<?php

namespace App\Controller\Admin;

use App\Entity\Prestataire;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PrestataireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prestataire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
         
            TextField::new('nom'),
            TextField::new('siteInternet'),
            TextField::new('numTel'),
            TextField::new('numTva'),
            AssociationField::new('images')
            
            
     
    
        
        ];
    }
    
}
