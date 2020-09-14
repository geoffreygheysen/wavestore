<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('firstname')
            ->add('lastname')
            ->add('email', EmailType::class)
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'Veuillez choisir' => null,
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ]
            ])
            ->add('date_of_birth')
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'empty_data' => '',
            ])
            ->add('newPassword', PasswordType::class, [
            'mapped' => false,
            'required' => false,
            'empty_data' => '',
            'constraints' => [
                new NotNull([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
            ])
            ->add('confPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'empty_data' => '',
                'constraints' => [
                    new NotNull([
                        'message' => 'Please confirm your password',
                    ]),
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
