<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Techno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom Projet',
                'required' => true,
            ])
            ->add('debut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('fin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('contexte', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('temps')
            ->add('besoin', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('bilan', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('doc', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('technos', EntityType::class, [
                'class' => Techno::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('screen', FileType::class, [
                'label' => 'Screen',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez mettre une image valide (.gif, .jpeg, .png, .jpg)',
                    ])
                ],
            ])
            ->add('github', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
