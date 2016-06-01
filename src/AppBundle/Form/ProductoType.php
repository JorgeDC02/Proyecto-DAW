<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SumbitType;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref', TextType::class)
            ->add('precio', NumberType::class)

            ->add('depts', EntityType::class, array(//propiedad de la clase Producto relacionada con la clase Departamento
                    'class' => 'AppBundle:Departamento',
                    'placeholder' => 'Seleciona el departamento',
                    'choice_label' => 'nombre',
                )
            )
            ->add('valoracion',IntegerType::class)

            ->add('marcas', EntityType::class, array(//propiedad de la clase Producto relacionada con la clase Marca
                    'class' => 'AppBundle:Marca',
                    'placeholder' => 'Selecciona la marca',
                    'choice_label' => 'nMarca',
                )
            )
            ->add('modelo', TextType::class)
            ->add('tipoProducto', TextType::class)
            ->add('descripcion', TextareaType::class)
            ->add('novedad', CheckboxType::class, array(
                    'label' => 'Novedad',
                    'required' => false
                )
            )

            //->add('urlImagen', new ImageType());
            ->add('urlImagen', EntityType::class, array(
                    'class' => 'AppBundle:Image',
                    'placeholder' => 'Selecciona la imagen',
                    'choice_label' => 'imageName',
                )
            )
            //->add('image', ImageType::class)
            //->add('submit', SubmitType::class, [
              //  'label' => $options['submit_label'],
            //])
            /*->add('destacado',ChoiceType::class, array(
                    'choices' => array(
                        'yes' => true,
                        'no' => false,
                    )
                )//0 o 1
            )*/

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver -> setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Producto',
                'cascade_validation' => true,
            ]
        );

    }

    public function getName()
    {
        return 'app_bundle_producto_type';
    }
}
