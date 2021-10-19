<?php

namespace App\Controller\Admin;

use App\Form\PictureType;
use App\Entity\Products\Products;
use App\Form\ProductVariationsType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
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
            ->setSearchFields(['id', 'name', 'price', 'tags', 'manufacturePartNumber', 'brandName'])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        $enabled = BooleanField::new('Enabled');
        $name = TextField::new('Name');
        $price = MoneyField::new('Price')->setCurrency('EUR');
        $tags = TextField::new('tags', 'Tags');
        $categories = AssociationField::new('categories', 'Categories');
        $pictureFiles = CollectionField::new('pictures', 'Pictures')->setEntryType(PictureType::class)->setLabel("Image");
        $pictureFilename = ImageField::new('picture.filename', 'Picture')->setBasePath('media/products');
        $createdAt = DateField::new('created_at')->setFormat('d MMM Y  h:m');;
        $updatedAt = DateField::new('updated_at')->setFormat('d MMM Y  h:m');;
        $id = IdField::new('id', 'ID');
        $manufacturePartNumber = TextField::new('manufacturePartNumber', 'GTIN')->setHelp('UPC, EAN, JAN, ISBN, ITF-14');
        $manufacturer = TextField::new('manufacturer', 'Manufacturer');
        $brandName = TextField::new('brandName', 'Brand Name');
        $productVariations = CollectionField::new('productVariations', 'Product Variations')
            ->allowAdd()
            ->allowDelete()
            ->setEntryIsComplex(true)
            ->setEntryType(ProductVariationsType::class)
            ->setFormTypeOptions([
                'by_reference' => 'false'
            ]);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$enabled, $pictureFilename, $name, $price, $createdAt, $updatedAt, $tags];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $enabled, $name, $brandName, $pictureFilename, $price, $productVariations,  $createdAt, $tags, $manufacturePartNumber, $manufacturer];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$enabled, $manufacturePartNumber, $name, $brandName, $manufacturer, $price, $tags, $categories, $pictureFiles, $productVariations];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$enabled, $manufacturePartNumber, $name, $brandName, $manufacturer, $price, $tags, $categories, $pictureFiles, $productVariations];
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        dd("persiste", $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if($entityInstance instanceof Products)
        {
            dd($entityInstance->getProductVariations()->getValues());
        }
    }
    
}
