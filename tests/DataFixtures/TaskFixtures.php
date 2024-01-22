<?php

namespace App\Tests\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {

        $createdAt = new \DateTimeImmutable();

        // Anonymous task to DO.
        $task1 = new Task();
        $task1->setTitle("Anonymous task to do");
        $task1->setContent("Anonymous task to do - content");
        $task1->setCreatedAt($createdAt);
        $task1->setAuthor(null);
        $manager->persist($task1);

        // Anonymous task DONE.
        $task2 = new Task();
        $task2->setTitle("Anonymous task done");
        $task2->setContent("Anonymous task done - content");
        $task2->setCreatedAt($createdAt);
        $task2->setIsDone(true);
        $task2->setAuthor(null);
        $manager->persist($task2);

        // Admin task DONE.
        $task3 = new Task();
        $task3->setTitle("Admin task done");
        $task3->setContent("Admin task done - content");
        $task3->setCreatedAt($createdAt);
        $task3->setIsDone(true);
        $task3->setAuthor($this->getReference('user1'));
        $manager->persist($task3);

        // Admin task to do.
        $task4 = new Task();
        $task4->setTitle("Admin task to do");
        $task4->setContent("Admin task to do - content");
        $task4->setCreatedAt($createdAt);
        $task4->setIsDone(false);
        $task4->setAuthor($this->getReference('user1'));
        $manager->persist($task4);

        // User task DONE.
        $task5 = new Task();
        $task5->setTitle("User task done");
        $task5->setContent("User task done - content");
        $task5->setCreatedAt($createdAt);
        $task5->setIsDone(true);
        $task5->setAuthor($this->getReference('user2'));
        $manager->persist($task5);

        // User task to do.
        $task6 = new Task();
        $task6->setTitle("User task to do");
        $task6->setContent("User task to do - content");
        $task6->setCreatedAt($createdAt);
        $task6->setIsDone(false);
        $task6->setAuthor($this->getReference('user2'));
        $manager->persist($task6);

        $manager->flush();

    }


    public function getDependencies(): array
    {
        return [UsersFixtures::class];

    }
}
