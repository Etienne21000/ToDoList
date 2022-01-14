<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $this->client->submit($form, ['email' => 'max@mail.com', 'password' => 'OpenClassrooms75!']);
    }

    public function loginAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit($form, ['email' => 'etienne@mail.com', 'password' => 'OpenClassrooms75!']);
    }

    public function testTaskList(): void
    {
        $this->client->request('GET', '/tasks');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskCreate(): void
    {
        $this->logInUser();
        $crawler = $this->client->request('POST', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Test tache 21';
        $form['task[content]'] = 'Test tache content 21';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    /*public function testTaskCreateUnauthorized(): void
    {
        $this->logInUser();
        $this->client->request('POST', '/tasks/8/edit');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }*/

    public function testTaskUpdate(): void
    {
        $this->loginAdmin();
        $crawler = $this->client->request('POST', '/tasks/21/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Test tache modification';
        $form['task[content]'] = 'Test tache content modification';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testToogleTask(): void
    {
        $this->loginAdmin();
        $this->client->request('POST', '/tasks/21/toggle');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteTask(): void
    {
        $this->loginAdmin();
        $this->client->request('POST', '/tasks/21/delete');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}