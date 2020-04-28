<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PaymentsFromPeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fields', TextType::class, ['empty_data' => ''])
            ->add(
                'startsOn',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'endsOn',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false,
            ]
        );
    }
}
