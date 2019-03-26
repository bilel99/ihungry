<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'name'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'firstname'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'user.password.fields.must.match',
                'required' => true,
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'password',
                        'class' => 'form-group form-control'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'repeat password',
                        'class' => 'form-group form-control'
                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
