<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'Entrer un nom pour la catégorie'
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le nom de la catégorie doit contenir au moins {{ limit }} caractéres.',
                        'max' => 70,
                        'maxMessage' => 'Le nom de la catégorie doit contenir au maximum {{ limit }} caractéres.'
                    ])
                ]
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
