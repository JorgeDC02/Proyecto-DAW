<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comentario', TextareaType::class)
            ->add('submit', SubmitType::class, [
                'label' => $options['submit_label']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver -> setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Comentario',
                'submit_label' => 'New comment',
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_comentario_type';
    }
}
