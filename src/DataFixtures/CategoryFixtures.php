<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    //CategoryFixtures deve essere creato prima di PrototypeProduitFixtures
    //PrototypeProduitFixtures lo faro' dipendente di CategoryFixtures
    public function load(ObjectManager $manager)
    {
        $category1= new Category();
        $category1->setLabel('Tupperware');
        $manager->persist($category1);
        $category2= new Category();
        $category2->setLabel('Gourde');
        $manager->persist($category2);
        $category3= new Category();
        $category3->setLabel('Couvert');
        $manager->persist($category3);

        $manager->flush();
    }
}
