<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        $fields = [
            EmailField::new('email'),
            TextField::new('adresse_rue'),
            IntegerField::new('adresse_num')

        ];
// affichage en détails (mode liste)
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('prestataire')
                ->setFormTypeOptions([
                    'by_reference' => false,
            ]);
            $fields[] = AssociationField::new('codePostal')
            ->setFormTypeOptions([
                'by_reference' => false,
            ]);
            $fields[] = AssociationField::new('commune')
            ->setFormTypeOptions([
                'by_reference' => false,
            ]);
            $fields[] = AssociationField::new('localite')
            ->setFormTypeOptions([
                'by_reference' => false,
                ]);
        }else{
            // partie édition
            $fields[] = AssociationField::new('codePostal')
            ->setFormTypeOptions([
                'by_reference' => true,
            ]);
               
            $fields[] = AssociationField::new('commune')
            ->setFormTypeOptions([
                'by_reference' => true,
            ]);
            
            $fields[] = AssociationField::new('localite')
            ->setFormTypeOptions([
                'by_reference' => true,
            ]);

            $fields[] = TextField::new('password');
           
            $fields[] = DateField::new('inscription');

            $fields[] = TextField::new('type_utilisateur');

            $fields[] = TextField::new('inscript_conf');
            
        }

        array_push(
            $fields,
            
            // DateField::new('inscription'),
            IntegerField::new('nb_essais'),
            BooleanField::new('banni'),
        );

        return $fields;
    }

}