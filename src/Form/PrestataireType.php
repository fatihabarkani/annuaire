<?php

namespace App\Form;


use App\Entity\Prestataire;
use App\Entity\CategorieService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PrestataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=> 'Nom',
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
            ->add('siteInternet', TextType::class, [
                'label'=> 'Site Internet',
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
            ->add('numTel', IntegerType::class, [
                'label'=> 'Numéro de téléphone',
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
            ->add('numTva', TextType::class, [
                'label'=> 'Numéro de TVA',
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
            ->add('images', FileType::class,[
                'label' => 'Sélectionnez une image',
                'multiple' => true,//une collection d'image par internaute
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new Image([
                            "maxSize" => "2M",
                            'maxSizeMessage' => 'La taille excède la taille maximum autorisée. La taille maximale est 2M.',
                            // le format de fichiers autorisés sont:
                            "mimeTypes" => [
                                "image/png",
                                "image/jpg",
                                "image/jpeg",
                                "image/gif"
                            ],
                            "mimeTypesMessage" => "Formats autorisés: png, jpg, jpeg ou gif!"
                        ])
                    ])
                ]
            ])
            ->add('categorieServices', EntityType::class, [
                'label'=> 'Les catégories de services que vous offrez',
                'class'=> CategorieService::class,
                'choice_label'=>'nom',
                'multiple'=>true,
                'expanded'=>true,
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
  
           ->add('submit', SubmitType::class,[
            'label'=> 'Confirmation',
            'attr'=>[
                'class'=>'btn btn-block',
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
