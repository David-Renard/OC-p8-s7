<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

//class TaskControllerTest extends WebTestCase
class TaskControllerTest extends AbstractTestController
{
    public function testOpenedTaskIfLogged(): void
    {
//        $client = static::createClient();
//
//        $userRepository = static::getContainer()->get(UserRepository::class);
//        $user=$userRepository->findOneBy(['email' => 'user1@test.com']);
//
////        dd($user);
//        $client->loginUser($user);

        $this->loggedAsUser();

        $this->client->request('GET', '/task');
//        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', "Voici l'ensemble de vos tâches ouvertes");
    }

//    public function testOpenedTaskUnlogged(): void
//    {
//        $this->client->request('GET', '/task');
//        $this->client->followRedirect();
//        $this->assertSelectorTextContains('h1', "Connectez-vous");
//    }
//
//    public function testCreateTaskIfLogged(): void
//    {
//        $this->loggedAsUser();
//
//        $this->client->request('GET', '/task/create');
//        $this->assertSelectorTextContains('h1', "créer une tâche");
//    }
//
//    public function testCreateTaskUnlogged(): void
//    {
//        $this->client->request('GET', '/task/create');
//        $this->assertSelectorTextContains('h1', "Connectez-vous");
//    }
//
//    public function testPostTaskSuccess(): void
//    {
//        $this->loggedAsUser();
//
//        $crawler = $this->client->request('GET', "/task/create");
//
//        // select the button
//        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
//
//        // retrieve the Form object for the form belonging to this button
//        $form = $buttonCrawlerNode->form();
//
//        // set values on a form object
//        $form['task[title]'] = 'Titre test';
//        $form['task[content]'] = 'Contenu test';
//
//        // submit the Form object
//        $this->client->submit($form);
//    }
}
