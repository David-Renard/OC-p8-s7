<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

class UserControllerTest extends AbstractTestController
{


    public function testLoginIfLogged(): void
    {
        $this->loggedAsUser();
        $this->client->request('GET', '/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "Voici l'ensemble de vos tâches ouvertes");

    }

    public function testRegisterIfLogged(): void
    {
        $this->loggedAsUser();
        $this->client->request('GET', '/user/create');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List");

    }

    public function testRegisterValid(): void
    {
        $crawler = $this->client->request('GET', '/user/create');
        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();
        $form['user[username]']               = 'test user';
        $form['user[email]']                  = 'toto-wowo@test.com';
        $form['user[plainPassword][first]']   = "maisonpoubelle";
        $form['user[plainPassword][second]']  = "maisonpoubelle";
        $form['user[roles][1]']->tick();
        $form['user[agreeTerms]']->tick();

        $this->client->submit($form);

        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findBy(['email' => 'toto-wowo@test.com']);

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connectez-vous pour accéder à votre espace!');
        $this->assertCount(1, $testUser);

    }

    public function testEditOwnProfile(): void
    {
        $this->loggedAsUser();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $userId = $userRepository->findOneBy(['email' => 'user2@test.com'])->getId();

        $crawler = $this->client->request('GET', "/user/edit/$userId");

        $buttonCrawlerNode = $crawler->selectButton("Modifier");
        $form = $buttonCrawlerNode->form();

        $form['user_edit[username]'] = "Test Edit";
        $form['user_edit[email]'] = "user2@test.com";
        $form['user_edit[plainPassword][first]'] = "nouveauPassword";
        $form['user_edit[plainPassword][second]'] = "nouveauPassword";

        $this->client->submit($form);

        $this->assertResponseRedirects("/task/p");
        $this->client->followRedirect();

        $this->assertSelectorTextContains('h1', "tâches");

    }

    public function testEditOtherUserProfile(): void
    {
        $this->loggedAsUserWithoutTasks();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $userId = $userRepository->findOneBy(['email' => 'user2@test.com'])->getId();

        $this->client->request('GET', "/user/edit/$userId");
        $this->assertResponseStatusCodeSame(403);

    }


}
