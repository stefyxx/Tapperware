<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Restaurant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    //deve essere creato dopo User -> implements DependentFixtureInterface
    public function load(ObjectManager $manager): void
    {
        //https://fakerphp.github.io/formatters/internet/
        $faker= Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 6; $i++) {
            $users = $manager->getRepository(User::class)->findAll();

            $resto = new Restaurant();
            $resto->setNom($faker->name());
            $resto->setVille($faker->city());
            $resto->setRue($faker->streetName());
            $resto->setNumero($faker->numberBetween(5, 100));
            $resto->setZip($faker->numberBetween($min = 1000, $max = 9999));
            $resto-> setNumeroTVA($faker->numberBetween(1, 5));
            $resto->setSiteWeb($faker->url());
            $resto-> setImage('resto.jpg');
            $resto->setIsActive(true);
            $resto->setUser($users[array_rand($users)]);
            $manager->persist($resto);
        }

        $manager->flush();
    }
    //deve essere creato dopo User 
    public function getDependencies()
    {
        return ([
            UserFixtures::class
        ]);
    }
}
