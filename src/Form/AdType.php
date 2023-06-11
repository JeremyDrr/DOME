<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Advertisement's title", "", [
                'attr' => [
                    'class' => 'form-control bg-transparent mb-3',
                ]
            ]))
            ->add('thumbnail', UrlType::class, $this->getConfiguration("Thumbnail", "", [
                'attr' => [
                    'class' => 'form-control bg-transparent mb-3',
                ]
            ]))
            ->add('description', TextareaType::class, $this->getConfiguration("Description", "", [
                'attr' => [
                    'class' => 'form-control bg-transparent mb-3 text-white'
                ]
            ]))
            ->add('categories', EntityType::class, $this->getConfiguration("Categories", "", [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-control bg-transparent mb-3',
                ]
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
