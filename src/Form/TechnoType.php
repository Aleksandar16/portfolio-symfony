<?php

namespace App\Form;

use App\Entity\Techno;
use App\Entity\Type;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de la technologie',
                ],
            ])
            ->add('type', EntityType::class, [
                'label' => ' ',
                'class' => Type::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Type de la technologie',
                ],
            ])
            ->add('image', FileType::class, [
                'label' => ' ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\File([
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
            ->add('submit', SubmitType::class, [
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Techno::class,
        ]);
    }
}