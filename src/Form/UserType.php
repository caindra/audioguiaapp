<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Nombre completo'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico'
            ])
            ->add('isAdmin', CheckboxType::class, [
                'label' => 'Es Administrador',
                'required' => false,
                'constraints' => [
                    new Assert\Callback([$this, 'validateAdminEditor'])
                ]
            ])
            ->add('isEditor', CheckboxType::class, [
                'label' => 'Es Editor',
                'required' => false,
                'constraints' => [
                    new Assert\Callback([$this, 'validateAdminEditor'])
                ]
            ])
            ->add('audioguides', CollectionType::class, [
                'entry_type' => AudioguideType::class, // Asume que tienes un formulario para Audioguide
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function validateAdminEditor(
        $object,
        ExecutionContextInterface $context,
        $payload
    ){
        $form = $context->getRoot();
        $isAdmin = $form->get('isAdmin')->getData();
        $isEditor = $form->get('isEditor')->getData();

        if (($isAdmin && !$isEditor) || (!$isAdmin && $isEditor)) {
            $context->buildViolation('Un usuario debe ser tanto Administrador como Editor, o ninguno.')
                ->addViolation();
        }
    }
}
