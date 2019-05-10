<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'title',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'title'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'required' => true,
                'label' => 'comment',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'comment'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
            'translation_domain' => 'forms'
        ]);
    }
}
