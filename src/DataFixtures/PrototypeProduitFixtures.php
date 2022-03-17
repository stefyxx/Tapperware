<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\PrototypeProduit;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;

//CategoryFixtures deve essere creato prima di PrototypeProduitFixtures
//PrototypeProduitFixtures dip da CategoryFixtures -> implements DependentFixtureInterface
class PrototypeProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //1) recuperare la lista di tutte le Category
        $categories = $manager->getRepository(Category::class)->findAll();
        

        //creo i prototype
        $p1 = new PrototypeProduit();
        $p1->setNomProduit('Tupperware petit');
        $p1->setPrixLocationUnitaire(0.10);
        $p1->setTailleCapacite('0.7 L pour 227 gr');
        $p1->setDescription('Capacité de 0.7 L, qui correspond à 227 gr et un diamètre de 12 cm et haut de 6.5 cm');
        $p1->setStock(10000);
        $p1->setImage('tupperwarePetit.jpg');
        $p1->setCategory($categories[array_rand($categories)]);
        /*for ($i = 0; $i < Count($categories); $i++) {
            if ($categories[$i]->getLabel() == explode(" ", $p1->getNomProduit())[0]) {
                $categ = new Category();
                $categ ->setLabel($categories[$i]->getLabel());
                $categ->getId($categories[$i]->getId()); !!!!
                //$p1->setCategory($categories[$i]->getId()); // non puoi perché si attende un Category di type Category
                $p1->setCategory($categ);
                break;
            }
        };*/
        $manager->persist($p1);
        //str_split($p1->getNomProduit)[0] //-> separa lettera per lettera il nomProd e ritorna un array
        //$p1->setCategory($categories[array_rand($categories)]); //->recupera random la categoria

        $p2 = new PrototypeProduit();
        $p2->setNomProduit('Tupperware moyen');
        $p2->setPrixLocationUnitaire(0.20);
        $p2->setTailleCapacite('1.1 L pour 293 gr');
        $p2->setDescription('Capacité de 1.1 L, qui correspond à 293 gr et un diamètre de 14 cm et haut de 8.5 cm');
        $p2->setStock(10000);
        $p2->setImage('tupperwareMoyen.jpg');
        $p2->setCategory($categories[array_rand($categories)]);
        $manager->persist($p2);

        $p3 = new PrototypeProduit();
        $p3->setNomProduit('Tupperware grand');
        $p3->setPrixLocationUnitaire(0.30);
        $p3->setTailleCapacite('1.5 L pour 350 gr');
        $p3->setDescription('Capacité de 1.5 L, qui correspond à 350 gr et un diamètre de 16 cm et haut de 10 cm');
        $p3->setStock(10000);
        $p3->setImage('tupperwareGrand.jpg');
        $p3->setCategory($categories[array_rand($categories)]);
        $manager->persist($p3);

        $p4 = new PrototypeProduit();
        $p4->setNomProduit('Gourde');
        $p4->setPrixLocationUnitaire(0.10);
        $p4->setTailleCapacite('50 cl');
        $p4->setDescription('50 cl');
        $p4->setStock(10000);
        $p4->setImage('gourde.jpg');
        $p4->setCategory($categories[array_rand($categories)]);
        $manager->persist($p4);

        $p5 = new PrototypeProduit();
        $p5->setNomProduit('Fourchette');
        $p5->setPrixLocationUnitaire(0.10);
        $p5->setTailleCapacite(NULL);
        $p5->setDescription('fourchette');
        $p5->setStock(10000);
        $p5->setImage('fourchette.jpg');
        $p5->setCategory($categories[array_rand($categories)]);
        $manager->persist($p5);

        $p6 = new PrototypeProduit();
        $p6->setNomProduit('Couteau');
        $p6->setPrixLocationUnitaire(0.10);
        $p6->setTailleCapacite(NULL);
        $p6->setDescription('couteau');
        $p6->setStock(10000);
        $p6->setImage('couteau.jpg');
        $p6->setCategory($categories[array_rand($categories)]);
        $manager->persist($p6);

        $p7 = new PrototypeProduit();
        $p7->setNomProduit('Cuillére');
        $p7->setPrixLocationUnitaire(0.10);
        $p7->setTailleCapacite(NULL);
        $p7->setDescription('cuillére');
        $p7->setStock(10000);
        $p7->setImage('cuillere.jpg');
        $p7->setCategory($categories[array_rand($categories)]);
        $manager->persist($p7);

        $manager->flush();
    }
    //2) CategoryFixtures deve essere creato prima di PrototypeProduitFixtures
    public function getDependencies()
    {
        return ([
            CategoryFixtures::class
        ]);
    }
}
