<?php

namespace App\Form;

use App\Entity\Products\Color;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ColorProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('colorValue', TextType::class, [
                'label' => 'Color',
                'help' => 'Product color ( Black, Red Or Blue...)',
                'attr' => [
                    'placeholder' => 'Red'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Color::class,
        ]);
    }
}
