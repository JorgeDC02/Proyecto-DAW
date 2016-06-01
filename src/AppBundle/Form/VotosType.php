<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VotosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valoracion', ChoiceType::class, array(
                'placeholder' => 'Selecciona tu voto',
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ),
            ))
        ->add('submit', SubmitType::class, [
        'label' => $options['submit_label']
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver -> setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Producto',
                //'cascade_validation' => true,
                'submit_label' => 'Votar',
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_votos_type';
    }
}
