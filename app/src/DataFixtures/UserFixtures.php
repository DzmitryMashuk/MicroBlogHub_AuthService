<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUser($manager, 'admin@gmail.com', 'admin');
        $this->createUser($manager, 'test@test.test', 'test');

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, string $email, string $password): void
    {
        $user = (new User())->setEmail($email);
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $manager->persist($user);
    }
}
