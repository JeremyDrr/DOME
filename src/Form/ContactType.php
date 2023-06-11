<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, $this->getConfiguration("Email Address", "Enter your email address", [
                'attr' => [
                    'class' => 'form-control bg-transparent'
                ]
            ]))
            ->add('topic', TextType::class, $this->getConfiguration("Topic", "Enter the topic", [
                'attr' => [
                    'class' => 'form-control bg-transparent'
                ]
            ]))
            ->add('content', TextareaType::class, $this->getConfiguration("Content", "Write what you want to tell us", [
                'attr' => [
                    'class' => 'form-control bg-transparent contact'
                ]
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
