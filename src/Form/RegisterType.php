<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commune;
use App\Entity\Localite;
use App\Entity\CodePostal;
use App\Repository\CommuneRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label'=>false
            ])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                // message d'erreur au cas où le mot de passe et la confirmation ne sont pas identiques
                'invalid_message'=> 'Le mot de passe et la confirmation doivent être identiques',
                'label'=>'Votre mot de passe',
                'required'=>true,
                // demande d'introduire le mot de passe
                'first_options'=>[
                    'label'=>'Mot de passe',
                    'attr'=>[
                        'class'=>'form-control',
                    ]

                ],
                //confirmation du mot de passe
                'second_options'=>[
                    'label'=>'Confirmez votre mot de passe',
                    'attr'=>[
                        'class'=>'form-control',
                    ]

                ]
            ])

            
            ->add('adresse_num', TextType::class,[
                'label'=>false
            ])
            ->add('adresse_rue', TextType::class,[
                'label'=>false
                
            ])

            ->add('commune', EntityType::class,[
                'label'=>false,
                'class'=>Commune::class,
                'required'=>true,
                'choice_label'=>'commune',
                'multiple'=>false,
                'expanded'=>false,
                'placeholder'=>'choix',


                //affichage sous forme de tri
                'query_builder'=> function (CommuneRepository $commune){
                    return $commune->createQueryBuilder('c')
                        ->orderBy('c.commune');
                }
                
            ])

            ->add('localite', EntityType::class,[
                'label'=>false,
                'class'=>Localite::class,
                'required'=>false,
                
            ])

            ->add('codePostal', EntityType::class,[
                'label'=>false,
                'class'=>CodePostal::class,
                'required'=>false,
                
            ])
            
            ->add('type_utilisateur', ChoiceType::class,[
                'label'=>'Type utilisateur',
                'choices'=>[
                'choix'=>null,
                'Internaute'=>"Internaute",
                'Prestataire'=>"Prestataire",
        

                ]    
                
            ])
            ->add('submit', SubmitType::class,[
                'label'=> 'Envoyer',
                'attr'=>[
                    'class'=>'btn btn-block',
                ]
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
