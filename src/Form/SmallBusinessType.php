<?php

namespace App\Form;

use App\Entity\SmallBusiness;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmallBusinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('logo')
            ->add('description')
            ->add('phone_number')
            ->add('address')
            ->add('facebook_page')
            ->add('Instagram_page')
            ->add('profile')
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SmallBusiness::class,
        ]);
    }
}
