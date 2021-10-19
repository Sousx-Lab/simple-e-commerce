<?php

namespace App\Form;

use App\Form\SizeType;
use App\Form\ColorProductType;
use Symfony\Component\Form\AbstractType;
use App\Entity\Products\ProductVariations;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductVariationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', CollectionType::class, [
                'entry_type' => ColorProductType::class,
                'required'       => false,
                'empty_data'     => null,
                'allow_delete'   => true,
                'allow_add'      => true,
                'delete_empty'   => true,
                'by_reference'   => false,
            ])
            ->add('size', CollectionType::class, [
                'entry_type' => SizeType::class,
                'required'       => false,
                'empty_data'     => null,
                'allow_delete'   => true,
                'allow_add'      => true,
                'delete_empty'   => true,
                'by_reference'   => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductVariations::class
        ]);
    }
}
