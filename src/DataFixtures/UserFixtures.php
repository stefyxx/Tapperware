<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $m)
    {
        $faker = Faker\Factory::create('fr_FR'); // mi da i nomi in francese // 'es_ES' in inglesesymfony console doctrine:

        $user = new User();
        $user->setNom('Admin');
        $user->setPrenom('Admin');
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'pass0'));
        $user->setTelephone($faker->phoneNumber());
        $user->setIsActive(true);
        $m->persist($user);

        for ($i = 1; $i < 4; $i++) {
            $user = new User();
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setEmail('user'.$i.'@user.com');
            //$user->setRoles(['ROLE_CLIENT', 'ROLE_MANAGER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'pass' . $i));
            $user->setTelephone($faker->phoneNumber());
            $user->setIsActive(true);
            $m->persist($user);
        }
        $m->flush();
    }
}
