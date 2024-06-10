<?php

namespace App\Form;

use App\Entity\Audioguide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudioguideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameEs', TextType::class, [
                'label' => 'Nombre de la audioguía (español)',
            ])
            ->add('nameEn', TextType::class, [
                'label' => 'Nombre de la audioguía (inglés)',
            ])
            ->add('textEs', TextType::class, [
                'label' => 'Texto de la audioguía (español)',
            ])
            ->add('textEn', TextType::class, [
                'label' => 'Texto de la audioguía (inglés)',
            ])
            ->add('audioEs', FileType::class, [
                'label' => 'Audio Español (MP3 file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('audioEn', FileType::class, [
                'label' => 'Audio Inglés (MP3 file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Imagen (PNG file)',
                'mapped' => false,
                'required' => false,
            ])
            //->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audioguide::class,
        ]);
    }
}
