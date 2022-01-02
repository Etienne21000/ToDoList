<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//use App\Repository\TaskRepository;

class TaskControllerTest extends webTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function logInUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit($form, ['email' => 'max@mail.com', 'password' => 'Equinox75!']);
    }

    public function loginAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit($form, ['email' => 'etienne@mail.com', 'password' => 'Equinox75!']);
    }

    public function testTaskList(): void
    {
        $this->client->request('GET', '/tasks');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskCreate(): void
    {
        $this->loginAdmin();
        $crawler = $this->client->request('POST', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Test tache';
        $form['task[content]'] = 'Test tache content';
        $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /*public function getRandomTaskId(): int
    {
        $idArray = [];
        $resp = '';
        $getTask = new TaskRepository();
        foreach ($getTask->findAll() as $task) {
            $taskId = $task->getId();
            array_push($idArray, $taskId);
        }
        shuffle($idArray);
        foreach ($idArray as $id){
            $resp = $id;
        }
        return $resp;
    }*/

    public function testTaskUpdate(): void
    {
        //$id = $this->getRandomTaskId();
        $this->loginAdmin();
        $crawler = $this->client->request('POST', '/tasks/6/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Test tache modification';
        $form['task[content]'] = 'Test tache content modification';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

}