<?php
//
//namespace App\Tests\Controller\Admin;
//
//use App\Repository\UserRepository;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//
//class TaskAdminControllerTest extends WebTestCase
//{
//    public function testIndexAnonymousTaskOpen(): void
//    {
//        $client = static::createClient();
//        $userRepository = static::getContainer()->get(UserRepository::class);
////        dd($userRepository->findOneBy(['email' => 'user1@test.com']));
//
//        // retrieve the test user
//        $testUser = $userRepository->findOneBy(['email' => 'user1@test.com']);
//
//        // simulate $testUser being logged in
//        $client->loginUser($testUser);
//
//        $client->request('GET', '/admin/task');
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'tâches anonymes');
//    }
//
//}
