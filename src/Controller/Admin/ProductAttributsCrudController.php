<?php

namespace App\Controller\Admin;

use App\Entity\Products\ProductAttributs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductAttributsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductAttributs::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product Attribute')
            ->setEntityLabelInPlural('Products Attributes')
            ->setSearchFields(['color', 'name', 'price', 'size'])
            ->setPaginatorPageSize(30);
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
