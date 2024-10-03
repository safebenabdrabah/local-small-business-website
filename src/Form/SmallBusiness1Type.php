<?php

namespace App\Form;

use App\Entity\SmallBusiness;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SmallBusiness1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('logo',FileType::class)
            ->add('description',TextareaType::class)
            ->add('phone_number',IntegerType::class)
            ->add('address',TextType::class)
            ->add('facebook_page',TextType::class)
            ->add('Instagram_page',TextType::class)
            ->add('categories', ChoiceType::class, [
                'choices' => [
                    'Category 1' => 'category_1',
                    'Category 2' => 'category_2',
                    'Category 3' => 'category_3',
                    
                ],
                'multiple' => true, 
                'placeholder' => 'Choose a category',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SmallBusiness::class,
        ]);
    }
}
