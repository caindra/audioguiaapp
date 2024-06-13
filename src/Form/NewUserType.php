<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class NewUserType extends AbstractType
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Nombre completo'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'required' => false // Para permitir que la contraseña no se tenga que actualizar siempre
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
