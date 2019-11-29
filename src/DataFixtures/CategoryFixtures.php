<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Guitares & Bass');
        $manager->persist($category);
        $category = new Category();
        $category->setName('Amplificateurs');
        $manager->persist($category);
        $category = new Category();
        $category->setName('Pedales');
        $manager->persist($category);
        $manager->flush();
    }
}
