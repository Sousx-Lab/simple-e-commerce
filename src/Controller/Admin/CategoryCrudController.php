<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\PictureType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Category')
            ->setSearchFields(['id', 'name', 'picture'])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        $imgfile = CollectionField::new('imgfile')->setEntryType(PictureType::class)->setLabel("Image");
        $name = TextField::new('name');
        $id = IntegerField::new('id', 'ID');
        $picture = ImageField::new('picture')->setBasePath('media/category');;
        $updatedAt = DateTimeField::new('updatedAt');
        $products = AssociationField::new('products');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $picture, $name];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $picture, $updatedAt, $products];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$imgfile, $name];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$imgfile, $name];
        }
    }
}
