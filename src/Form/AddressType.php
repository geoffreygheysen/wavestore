<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => "John",
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Doe",
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse",
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('postal_code', NumberType::class, [
                'label' => "Code Postal",
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('box', TextType::class, [
                'label' => "Boîte",
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => "Pays",
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('btAdd',SubmitType::class, [
                'label' => "Enregistrer",
                'attr' => [
                    'class' => 'btn btn-outline-dark mb-3'
                ],
            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
