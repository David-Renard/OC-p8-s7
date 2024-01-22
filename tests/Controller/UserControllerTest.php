<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserController extends WebTestCase
{
    public function testOpenedTaskIfLogged(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['email' => 'user2@test.com']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/task');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', "Voici l'ensemble de vos tâches ouvertes");
    }
}