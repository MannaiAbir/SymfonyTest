<?php

namespace App\Form;

use App\Entity\Market;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('validdate', null, [
                'widget' => 'single_text',
            ])
            ->add('enabled')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',])        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Market::class,
        ]);
    }
}
