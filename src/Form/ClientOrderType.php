<?php

namespace App\Form;

use App\Entity\ClientOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientOrderType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('prix')
      ->add('serveur')
      ->add('numTable')
      ->add('dishes');

    if ($options['data']->getId()) {
      $builder->add('status', ChoiceType::class, [
        'expanded' => true,
        'multiple' => false,
        'choices' => [
          'Prise' => 'Prise',
          'Préparee ' => 'Préparee',
          'Servie  ' => 'Servie',
          'Payee ' => 'Payee',
        ]
      ]);
    }
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => ClientOrder::class,
    ]);
  }
}
