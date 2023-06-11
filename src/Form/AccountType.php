<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("First Name", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",

                ],
            ])
            )
            ->add('lastName', TextType::class, $this->getConfiguration("Last Name", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",

                ],
            ])
            )
            ->add('picture', TextType::class, $this->getConfiguration('Profile Picture', "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",

                ],
                'required' => false,
            ]))
            ->add('email', EmailType::class, $this->getConfiguration("Email Address", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                    'disabled' => true,
                ],
            ])
            )
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "", [
                'attr' => [
                    'class' => "form-control bg-transparent mb-3",
                ],
                'required' => false,
            ]))
            ->add('description', TextareaType::class,$this->getConfiguration("Description", "", [
                'attr' => [
                    'class' => "form-control bg-transparent input mb-3",
                ],
                'required' => false,
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
