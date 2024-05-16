<?php

namespace App\DataFixtures;

use App\Factory\AudioguideFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AudioguideFactory::createMany(5);

        UserFactory::createOne([
            'email' => 'correo@email.com',
            'fullName' => 'Paco Martínez Sánchez',
            'password' => 'editor',
            'isEditor' => true,
            'isAdmin' => false
        ]);

        UserFactory::createOne([
            'email' => 'admin@email.com',
            'fullName' => 'Sheldon Cooper',
            'password' => 'admin',
            'isAdmin' => true
        ]);

        $manager->flush();
    }
}
