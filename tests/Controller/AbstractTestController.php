<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestController extends WebTestCase
{


    protected $client;
    
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function loggedAsAdmin()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user with admin role
        $testUser = $userRepository->findOneBy(['email' => 'user1@test.com']);

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }

    protected function loggedAsUser()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['email' => 'user2@test.com']);

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }

    protected function loggedAsUserWithoutTasks()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['email' => 'user3@test.com']);

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }
}