<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

class PromocionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descuentoPorc', TextType::class, ['error_bubbling' => true])
            ->add('product', EntityType::class, array(
                    'class' => 'AppBundle:Producto',
                    'placeholder' => 'Seleccione el producto',
                    'choice_label' => 'id'
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Promocion',
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_promocion_type';
    }
}
