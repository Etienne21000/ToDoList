<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends webTestCase
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

    public function testListAction(): void
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction(): void
    {
        $this->loginAdmin();
        $crawler = $this->client->request('POST', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[pseudo]'] = 'userTest4';
        $form['user[password][first]'] = 'OpenClassrooms75!';
        $form['user[password][second]'] = 'OpenClassrooms75!';
        $form['user[email]'] = 'testuser4@mail.com';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testEditAction(): void
    {
        $this->loginAdmin();
        $crawler = $this->client->request('POST', '/users/4/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[pseudo]'] = 'userTest';
        $form['user[password][first]'] = 'testPass';
        $form['user[password][second]'] = 'testPass';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}