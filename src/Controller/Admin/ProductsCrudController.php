<?php

namespace App\Controller\Admin;

use App\Form\PictureType;
use App\Entity\Products\Products;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Products')
            ->setSearchFields(['id', 'name', 'price', 'tags'])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        $enabled = BooleanField::new('Enabled');
        $name = TextField::new('Name');
        $price = IntegerField::new('Price');
        $tags = TextField::new('tags', 'Tags');
        $categories = AssociationField::new('categories', 'Categories');
        $pictureFiles = CollectionField::new('pictures', 'Pictures')->setEntryType(PictureType::class)->setLabel("Image");
        $pictureFilename = ImageField::new('picture.filename', 'Picture')->setBasePath('media/products');
        $createdAt = DateField::new('created_at')->setFormat('d MMM Y  h:m');;
        $updatedAt = DateField::new('updated_at')->setFormat('d MMM Y  h:m');;
        $id = IdField::new('id', 'ID');
        $productAttributs = AssociationField::new('productAttributs', 'Attributes');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name,$pictureFilename, $price, $enabled,  $createdAt, $updatedAt, $tags];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name,$pictureFilename, $price, $enabled,$productAttributs,  $createdAt, $tags];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$enabled, $name, $price, $tags, $categories, $pictureFiles, $productAttributs];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$enabled, $name, $price, $tags, $categories, $productAttributs, $pictureFiles];
        }
    }
}
