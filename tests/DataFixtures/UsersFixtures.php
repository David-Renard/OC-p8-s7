<?php

namespace App\Tests\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{


    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Admin
        $user1 = new User();
        $user1->setUsername('user1')
            ->setEmail('user1@test.com')
            ->setPassword($this->passwordHasher->hashPassword($user1, 'passsword'))
            ->setRoles(['ROLE_ADMIN']);
        $this->addReference('user1', $user1);
        $manager->persist($user1);

        // User with tasks
        $user2 = new User();
        $user2->setUsername('user2')
            ->setEmail('user2@test.com')
            ->setPassword($this->passwordHasher->hashPassword($user2, 'passsword'));
        $this->addReference('user2', $user2);
        $manager->persist($user2);

        // User with no tasks
        $user3 = new User();
        $user3->setUsername('user3')
            ->setEmail('user3@test.com')
            ->setPassword($this->passwordHasher->hashPassword($user3, 'passsword'));
        $this->addReference('user3', $user3);
        $manager->persist($user3);

        $manager->flush();
    }
}