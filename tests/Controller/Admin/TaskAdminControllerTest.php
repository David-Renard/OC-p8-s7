<?php
//
//namespace App\Tests\Controller\Admin;
//
//use App\Tests\Controller\AbstractTestController;
//
//class TaskAdminControllerTest extends AbstractTestController
//{
//    public function testAdminAnonymousTasks(): void
//    {
//        $this->loggedAsAdmin();
//
//        $this->client->request('GET', '/admin/task');
//        $this->assertSelectorTextContains('h1', "Voici l'ensemble des tâches anonymes");
//    }
//
//    public function testUserAnonymousTasks(): void
//    {
//        $this->loggedAsUser();
//
//        $this->client->request('GET', '/admin/task');
//        $this->assertResponseStatusCodeSame(403);
//    }
//}
