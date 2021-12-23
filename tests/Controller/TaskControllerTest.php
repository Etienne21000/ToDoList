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
        $this->client->submit($form, ['email' => 'max@mail.com', 'password' => 'Equinox75!']);
        //$this->assertResponseIsSuccessful();
    }

    public function loginAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit($form, ['email' => 'etienne@mail.com', 'password' => 'Equinox75!']);
    }

    public function testTaskList(): void
    {
        $this->logInUser();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskCreate(): void
    {
        $this->client->request('POST', '/tasks/create');

    }

}