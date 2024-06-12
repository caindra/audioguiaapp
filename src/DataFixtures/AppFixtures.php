<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\AudioguideFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        AudioguideFactory::createMany(5);

        UserFactory::createOne([
            'email' => 'correo@email.com',
            'fullName' => 'Paco Martínez Sánchez',
            'password' => $this->passwordHasher->hashPassword(
                new User(), 'editor'
            ),
            'isEditor' => true,
            'isAdmin' => false
        ]);

        UserFactory::createOne([
            'email' => 'admin@email.com',
            'fullName' => 'Sheldon Cooper',
            'password' => $this->passwordHasher->hashPassword(
                new User(), 'admin'
            ),
            'isAdmin' => true
        ]);

        $manager->flush();
    }
}
