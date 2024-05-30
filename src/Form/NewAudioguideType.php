<?php

namespace App\Form;

use App\Entity\Audioguide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewAudioguideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameEs')
            ->add('nameEn')
            ->add('textEs')
            ->add('textEn')
            ->add('audioEs')
            ->add('audioEn')
            ->add('image')
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audioguide::class,
        ]);
    }
}
