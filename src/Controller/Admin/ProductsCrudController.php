<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\PictureType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
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
            ->setSearchFields(['id', 'name', 'SKU', 'price', 'tags', 'quantity'])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        $enabled = BooleanField::new('Enabled');
        $quantity = IntegerField::new('Quantity');
        $name = TextField::new('Name');
        $price = IntegerField::new('Price');
        $tags = TextField::new('tags', 'Tags');
        $categories = AssociationField::new('categories', 'Categories');
        $sku = TextField::new('sku', 'SKU product')->setRequired(true);
        $pictureFiles = CollectionField::new('pictures', 'Pictures')->setEntryType(PictureType::class)->setLabel("Image");
        $iD = TextField::new('ID');
        $pictureFilename = ImageField::new('picture.filename', 'Picture')->setBasePath('media/products');
        $createdAt = DateField::new('created_at');
        $id = IdField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $enabled, $quantity, $pictureFilename, $name, $price, $createdAt, $tags, $sku];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$iD, $enabled, $pictureFilename, $name, $price, $createdAt, $tags, $sku];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$enabled, $quantity, $name, $price, $tags, $categories, $sku, $pictureFiles];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$enabled, $quantity, $name, $price, $tags, $categories, $sku, $pictureFiles];
        }
    }
}
