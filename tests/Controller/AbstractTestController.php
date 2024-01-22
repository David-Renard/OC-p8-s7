<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestController extends WebTestCase
{
    protected function loggedAsAdmin(): void
    {
//        $client
        $userRepository = static::getContainer()->get(UserRepository::class);
//        $admin = $userRepository->findBy()
    }
}