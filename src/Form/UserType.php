<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Username', TextType::class, ['required' => true])
            ->add('Email', EmailType::class, ['required' => true])
            ->add('Firstname', TextType::class, ['required' => true])
            ->add('Lastname', TextType::class, ['required' => true])
            ->add('JobTitle', TextType::class, ['required' => true])
            ->add('roles', ChoiceType::class, [
              'expanded' => true,
              'multiple' => true,
              'choices' => [
                'ROLE_ADMIN' => 'ROLE_ADMIN',
                'ROLE_USER' => 'ROLE_USER',
              ]
            ])
            ->add('Enabled')
            ->add('CreatedAt')
            ->add('UpdatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
