<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testNotFound(): void
    {
        $this->client->request('GET', '/notFound');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}