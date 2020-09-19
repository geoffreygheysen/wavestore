<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder
        //     ->add('email')
        //     ->add('password')
        //     ->add('firstname')
        //     ->add('lastname')
        //     ->add('date_of_birth')
        //     ->add('sexe')
        // ;

        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'Veuillez choisir' => null,
                    'homme' => 'homme',
                    'femme' => 'femme',
                ],
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('date_of_birth', BirthdayType::class, [
                'label' => "Date de naissance",
                'attr' => [
                    'class' => 'mb-3',
                ],
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('newPassword', PasswordType::class, [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'form-control mb-3',
            ],
            'constraints' => [
                new NotNull([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    'max' => 4096,
                ]),
            ],
            ])
            ->add('confPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Please confirm your password',
                    ]),
                ],
            ])
            ->add('btModif',SubmitType::class, [
                'label' => "Enregistrer",
                'attr' => [
                    'class' => 'btn btn-outline-dark mb-3'
                ],
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
