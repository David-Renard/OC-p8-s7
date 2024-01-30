<?php

namespace App\Tests\Controller\Admin;

use App\Repository\UserRepository;
use App\Tests\Controller\AbstractTestController;

class UserAdminControllerTest extends AbstractTestController
{

    private int $invalidUserId = 10000000;


    public function testAdminUsersUnlogged(): void
    {
        $this->client->request('GET', '/admin/user');
        $this->client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Connectez-vous');

    }

    public function testAdminUsersAsUser(): void
    {
        $this->loggedAsUser();
        $this->client->request('GET', '/admin/user');

        $this->assertResponseStatusCodeSame(403);

    }

    public function testAdminUsersAsAdmin(): void
    {
        $this->loggedAsAdmin();
        $this->client->request('GET', '/admin/user');

        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "Liste des utilisateurs");
    }

    public function testDeleteInvalidUser(): void
    {
        $this->loggedAsAdmin();
        $this->client->request('GET', "/admin/user/delete/.$this->invalidUserId");

        $this->assertResponseStatusCodeSame(404);

    }

    public function testDeleteValidUser(): void
    {
        $this->loggedAsAdmin();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $validUserId = $userRepository->findOneBy(['email' => 'user3@test.com'])->getId();
        $this->client->request('GET', "/admin/user/delete/$validUserId");
        $this->client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

    }

    public function testEditInvalidUser(): void
    {
        $this->loggedAsAdmin();
        $this->client->request('GET', "/admin/user/edit/.$this->invalidUserId");

        $this->assertResponseStatusCodeSame(404);

    }

    public function testEditValidUser(): void
    {
        $this->loggedAsAdmin();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $validUserId = $userRepository->findOneBy(['email' => 'user3@test.com'])->getId();
        $crawler = $this->client->request('GET', "/admin/user/edit/$validUserId");

        $this->assertSelectorTextContains('h1', "Modifier le rôle de l'utilisateur");

        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();

        $form['admin_user[roles][1]']->tick();
        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "Liste des utilisateurs");

    }


}
