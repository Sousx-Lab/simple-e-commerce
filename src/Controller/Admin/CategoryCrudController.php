<?php

namespace App\Controller\Admin;

use App\Entity\Categories\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
        $isEnabled = BooleanField::new('isEnabled')->setLabel("Enabled");
        $inMenu = BooleanField::new('InMenu')->setLabel("View in menu");;
        $imgfile = Field::new('imgfile')->setFormType(FileType::class)->setLabel("Image");
        $name = TextField::new('name');
        $id = IntegerField::new('id', 'ID');
        $picture = ImageField::new('picture')->setBasePath('media/category');
        $updatedAt = DateTimeField::new('updatedAt');
        $products = AssociationField::new('products');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $isEnabled, $inMenu, $picture, $name];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $isEnabled, $inMenu, $name, $picture, $updatedAt, $products];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$imgfile, $name, $isEnabled, $inMenu,];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$imgfile, $name, $isEnabled, $inMenu];
        }
    }
}
