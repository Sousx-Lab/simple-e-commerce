<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new SubCategory();
        $category->setName('Guitares Elctrique');

        $manager->persist($category);

        $category = new SubCategory();
        $category->setName('Guitares Bass');

        $manager->persist($category);

        $category = new SubCategory();
        $category->setName('Guitares Acoustique');

        $manager->persist($category);

        $manager->flush();
    }
}