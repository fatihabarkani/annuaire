<?php

namespace App\Form;

use App\Entity\Internaute;
use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class InternauteType extends AbstractType
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
        ->add('prenom', TextType::class, [
            'label'=> 'Prénom',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])
      
        ->add('images', FileType::class,[
            'label' => 'Sélectionnez une image',
            'multiple' => false,//une image par internaute
            'mapped' => false,
            'required' => false,
            'constraints' => [
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
            ]
        ])
        ->add('newsletter', CheckboxType::class, [
            'label' => 'Souhaitez-vous recevoir la Newsletter?',
            'required' => false,
            'attr'=>[
                'class'=>'form-control',
                'input'=>'checkbox',
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
            'data_class' => Internaute::class,
        ]);
    }
}
