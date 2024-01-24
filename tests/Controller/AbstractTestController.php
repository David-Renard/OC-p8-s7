<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestController extends WebTestCase
{


    protected KernelBrowser $client;
    
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function loggedAsAdmin(): KernelBrowser
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['email' => 'user1@test.com']);

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }

    protected function loggedAsUser(): KernelBrowser
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['email' => 'user2@test.com']);

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }
}