<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("First Name", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                ]
            ]))
            ->add('lastName', TextType::class, $this->getConfiguration("Last Name", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                ]
            ]))
            ->add('email', EmailType::class, $this->getConfiguration("Email address", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                ]
            ]))
            ->add('hash', PasswordType::class, $this->getConfiguration("Password", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                ]
            ]))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirm Password", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                ]
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
