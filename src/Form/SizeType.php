<?php

namespace App\Form;

use App\Entity\Products\Size;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sizeValue', TextType::class,[]);
            // ->addEventListener(FormEvents::POST_SUBMIT,
            //     function(FormEvent $event) use($builder)
            //     {
            //         $form = $event->getForm();
            //         $child = $event->getData();
                    
            //     }
            // );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Size::class
        ]);
    }
}
