<?php

namespace App\Tests\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

//class UserControllerTest extends WebTestCase
class UserControllerTest extends AbstractTestController
{
//    public function testLoginIfLogged(): void
//    {
//        $this->loggedAsUser();
//        $this->client->request('GET', '/login');
//        $this->client->followRedirect();
//        $this->assertSelectorTextContains('h1', "Voici l'ensemble de vos tâches ouvertes");
//    }
//
//    public function testRegisterIfLogged(): void
//    {
//        $this->loggedAsUser();
//        $this->client->request('GET', '/user/create');
//        $this->client->followRedirect();
//        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List");
//    }

//    public function testRegisterValid(): void
//    {
//        $crawler = $this->client->request('GET', '/user/create');
//        $buttonCrawlerNode = $crawler->selectButton("Ajouter");
//
//        $form = $buttonCrawlerNode->form();
//        $form['user[username]']               = 'test user';
//        $form['user[email]']                  = 'test-user@test.com';
//        $form['user[plainPassword][first]']   = "password";
//        $form['user[plainPassword][second]']  = "password";
//        $form['user[roles][1]']->tick();
//        $form['user[agreeTerms]']->tick();
//
//        $testUser = new User();
//        $testUser->setUsername($form->get('user[username]')->getValue());
//        $testUser->setEmail($form->get('user[email]')->getValue());
//        $testUser->setPassword($form->get('user[plainPassword][first]')->getValue());
//
//        $userRepository = $this->createMock(UserRepository::class);
//        $manager = $this->createMock(EntityManagerInterface::class);
//
//        $manager->expects($this->once())
//            ->method('persist')
//            ->with($testUser);
//
//        $manager->expects($this->once())
//            ->method('flush')
//            ->willReturn(true)
//        ;
//
//        $this->client->submit($form);
//
////        $testUser = $userRepository->findOneBy(['email' => 'test-user@test.com']);
//        dump($testUser);
//        $this->assertResponseRedirects('/login');
//        $this->client->followRedirect();
//        $this->assertSelectorTextContains('h1', 'Connectez-vous pour accéder à votre espace');
//        $crawler = $this->client->followRedirect();
//
////        $this->assertTrue($client->getResponse()->isRedirection());
////        $this->assertResponseIsSuccessful();
////        $this->assertSelectorTextContains('h1', "Inscrivez-vous!");
//        $this->assertSelectorTextContains('h1', "Connectez-vous pour accéder à votre espace");
//        $this->assertStringContainsString("Votre compte a bien été créé!", $crawler->text());
//    }

//    public function testEditOwnProfile(): void
//    {
//        $this->loggedAsUser();
//
//        $userRepository = static::getContainer()->get(UserRepository::class);
//        $userId = $userRepository->findOneBy(['email' => 'user2@test.com'])->getId();
//
//        $crawler = $this->client->request('GET', "/user/edit/$userId");
//
//        $buttonCrawlerNode = $crawler->selectButton("Modifier");
//        $form = $buttonCrawlerNode->form();
//
//        $form['user_edit[username]'] = "Test Edit";
//        $form['user_edit[email]'] = "user2@test.com";
//        $form['user_edit[plainPassword][first]'] = "nouveauPassword";
//        $form['user_edit[plainPassword][second]'] = "nouveauPassword";
//
//        $this->client->submit($form);
//
//        $this->assertResponseRedirects("/task/p");
//        $this->client->followRedirect();
//
//        $this->assertSelectorTextContains('h1', "tâches");
//    }
//
//    public function testEditOtherUserProfile(): void
//    {
//        $this->loggedAsUserWithoutTasks();
//
//        $userRepository = static::getContainer()->get(UserRepository::class);
//        $userId = $userRepository->findOneBy(['email' => 'user2@test.com'])->getId();
//
//        $this->client->request('GET', "/user/edit/$userId");
//        $this->assertResponseStatusCodeSame(403);
//    }

    public function testEditProfileUnlogged(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userId = $userRepository->findOneBy(['email' => 'user2@test.com'])->getId();
        $this->client->request('GET', "/user/edit/$userId");

        $this->client->followRedirect();
        $this->assertResponseRedirects('/login');
    }
}
