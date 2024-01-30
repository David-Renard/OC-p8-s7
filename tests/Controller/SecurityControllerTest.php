<?php

namespace App\Tests\Controller;


class SecurityControllerTest extends AbstractTestController
{


    public function testLoginSuccess(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerNode = $crawler->selectButton("Se connecter");

        $form = $buttonCrawlerNode->form();

        $form['email'] = "user2@test.com";
        $form['password'] = "passsword";

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

    }

    public function testLoginFailure(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerNode = $crawler->selectButton("Se connecter");

        $form = $buttonCrawlerNode->form();
        $form['email'] = "fakemail@test.com";
        $form['password'] = "password";

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "Connectez-vous");

    }
}
