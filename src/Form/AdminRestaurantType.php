<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Restaurant;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Title',
                'label_format' => 'restaurant.title',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.title'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'label_format' => 'restaurant.description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.description'
                ]
            ])
            ->add('libelleVille', TextType::class, [
                'required' => true,
                'label' => 'Ville',
                'label_format' => 'restaurant.libelleVille',
                'attr' => [
                    'class' => 'form-control restaurant_libelleVille',
                    'placeholder' => 'restaurant.ville'
                ]
            ])
            ->add('adress', TextType::class, [
                'required' => true,
                'label' => 'Adress',
                'label_format' => 'restaurant.adress',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.adress'
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => false,
                'label' => 'Price',
                'label_format' => 'restaurant.price',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'restaurant.price'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'title',
                'label' => 'Category',
                'label_format' => 'restaurant.categorie',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'tag',
                'label' => 'Tags',
                'label_format' => 'restaurant.tag',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('media', CollectionType::class, [
                'entry_type' => MediaType::class,
                'entry_options' => ['label' => 'Media'],
                'allow_add' => true,
                'prototype' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'label' => 'Media',
                'label_format' => 'restaurant.media',
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
