<?php

namespace App\Tests\Controller;

use App\Entity\Task;

class TaskControllerTest extends AbstractTestController
{


    public function testOpenedTaskIfLogged(): void
    {
        $this->loggedAsUser();

        $this->client->request('GET', '/task/p');

        $this->assertSelectorTextContains('h1', "Voici l'ensemble de vos tâches ouvertes");

    }

    public function testCreateTaskIfLogged(): void
    {
        $this->loggedAsUser();

        $this->client->request('GET', '/task/create');
        $this->assertSelectorTextContains('h1', "créer une tâche");

    }

    public function testPostTaskSuccess(): void
    {
        $this->loggedAsUser();

        $crawler = $this->client->request('GET', "/task/create");

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['task[title]'] = 'Titre test';
        $form['task[content]'] = 'Contenu test';

        // submit the Form object
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "vos tâches ouvertes");

    }

    public function testUpdateAuthorTask(): void
    {
        $this->loggedAsUser();
        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $validTask = $taskRepository->findOneBy(['title' => 'User task done']);
        $validTaskId = $validTask->getId();

        $crawler = $this->client->request('GET', "/task/update/$validTaskId");

        $this->assertSelectorTextContains('h1', 'Modifier cette tâche');

        $buttonCrawlerNode = $crawler->selectButton("Modifier");
        $form = $buttonCrawlerNode->form();

        $form['task[title]'] = "Nouveau titre";
        $form['task[content]'] = "Nouveau contenu";

        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertSelectorTextContains("h1", "Voici l'ensemble de vos tâches");
        // $this->assertEquals("Nouveau titre", $validTask->getTitle());

    }

    public function testUpdateNonAuthorTask(): void
    {
        $this->loggedAsUser();
        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $validTask = $taskRepository->findOneBy(['title' => 'Admin task to do']);
        $validTaskId = $validTask->getId();

        $this->client->request('GET', "/task/update/$validTaskId");

        $this->assertResponseStatusCodeSame(403);

    }


}
