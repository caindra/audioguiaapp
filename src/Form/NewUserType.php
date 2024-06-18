<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewUserType extends AbstractType
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
            ->add('role', ChoiceType::class, [
                'label' => 'Rol',
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Editor' => 'ROLE_EDITOR',
                ],
                'expanded' => true,
                'multiple' => false,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debe seleccionar un rol.',
                    ]),
                ],
            ]);

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if ($user instanceof User) {
                $role = $form->get('role')->getData();
                if ($role === 'ROLE_ADMIN') {
                    $user->setIsAdmin(true);
                    $user->setIsEditor(false);
                } elseif ($role === 'ROLE_EDITOR') {
                    $user->setIsAdmin(false);
                    $user->setIsEditor(true);
                }
            }
        });
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
