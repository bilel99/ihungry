<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Restaurant;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.title'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.description'
                ]
            ])
            ->add('libelleVille', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control restaurant_libelleVille',
                    'placeholder' => 'restaurant.ville'
                ]
            ])
            ->add('adress', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.adress'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.categorie'
                ]
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'required' => true,
                'label' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.tag'
                ]
            ])
            ->add('media', CollectionType::class, [
                'entry_type' => MediaType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'label' => false,
                'attr' => [
                    'class' => 'my-selector',
                    'placeholder' => 'restaurant.media'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
            'translation_domain' => 'forms'
        ]);
    }
}
