<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', HiddenType::class, [
                'required' => true,
                'label' => false,
                'data' => '1',
            ])
            ->add('name', HiddenType::class, [
                'required' => true,
                'label' => false,
                'data' => 'Image'
            ])
            ->add('file', FileType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'file'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'translation_domain' => 'forms'
        ]);
    }
}
