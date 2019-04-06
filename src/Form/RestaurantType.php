<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
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
            ]);
            //->add('tag')
            //->add('categorie')

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
            'translation_domain' => 'forms'
        ]);
    }
}
