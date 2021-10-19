<?php

namespace App\Controller\Admin;

use App\Entity\Products\ProductVariations;
use App\Form\ColorProductType;
use App\Form\SizeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductVariationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductVariations::class;
    }

    
    public function configureFields(string $pageName): iterable
    {    
        $size = CollectionField::new('size', 'Size')
        ->allowAdd()
            ->allowDelete()
            ->setEntryIsComplex(true)
            ->setEntryType(SizeType::class)
            ->setFormTypeOptions([
                'by_reference' => 'false'
            ]);
        $color = CollectionField::new('color')->allowAdd()
        ->allowDelete()
        ->setEntryIsComplex(true)
        ->setEntryType(ColorProductType::class)
        ->setFormTypeOptions([
            'by_reference' => 'false'
        ]);
        $prdoduct = AssociationField::new('product');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$prdoduct, $color, $size];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$prdoduct, $color, $size];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$prdoduct, $color, $size];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$prdoduct, $color, $size];
        }
    }
}
