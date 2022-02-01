<?php

namespace App\Form;

use App\Entity\CategorieService;
use App\Entity\Commune;
use App\Entity\Localite;
use App\Entity\CodePostal;
use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchPresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
        ->add('mots', SearchType::class, [
            'label' => false,
            'attr' => [
                'class'=>'form-control',
                'placeholder'=>'Nom',
                
            ],
            'required'=> false
        
            
        ])

        ->add('categorieServices', EntityType::class, [
            'label'=>false,
            'class'=>CategorieService::class,
            'required'=>false,
            'placeholder'=>'Catégorie de service'
           
        ])

        ->add('codePostal', EntityType::class, [
            'label'=>false,
            'class'=>CodePostal::class,
            'required'=>false,
            'placeholder'=>'Code postal'
           
        ])
        ->add('localite', EntityType::class, [
            'label'=>false,
            'class'=>Localite::class,
            'required'=>false,
            'placeholder'=>'Localité'
           
        ])
        ->add('commune', EntityType::class, [
            'label'=>false,
            'class'=>Commune::class,
            'required'=>false,
            'placeholder'=>'Commune'
           
        ])

        ->add('Rechercher', SubmitType::class, [
            'attr' => [
                'class' => 'btn primary',
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestataire::class,
        ]);
    }
}
