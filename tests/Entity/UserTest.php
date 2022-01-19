<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private $user;

    private $date;

    private $task;

    public function setUp(): void
    {
        $this->user = new User();
        $this->date = new \DateTime();
        $this->task = new Task();
    }

    public function testUserId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testUserPseudo(): void
    {
        $pseudo = "jean54";
        $this->user->setPseudo("jean54");
        $this->assertSame($pseudo, $this->user->getPseudo());
    }

    public function testUserPassword(): void
    {
        $password = "OpenClassrooms2021";
        $this->user->setPassword("OpenClassrooms2021");
        $this->assertSame($password, $this->user->getPassword());
    }

    public function testUserMail(): void
    {
        $email = "mail@mail.com";
        $this->user->setEmail("mail@mail.com");
        $this->assertSame($email, $this->user->getEmail());
    }

    public function testUserRoles(): void
    {
        $role = ['ROLE_ADMIN', 'ROLE_USER'];
        $this->user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->assertSame($role, $this->user->getRoles());
    }

    public function testUserIdentifier(): void
    {
        $identifier = "mail@mail.com";
        $this->user->setEmail("mail@mail.com");
        $this->assertSame($identifier, $this->user->getUserIdentifier());
    }

    public function testUserTask(): void
    {
        $taskSetUp = $this->task->getUser();
        $tasks = $this->user->getTasks($taskSetUp);
        $this->assertSame($this->user->getTasks(), $tasks);
    }

    public function testUserAddTask(): void
    {
        $this->user->addTask($this->task);
        $this->assertCount(1, $this->user->getTasks());
    }

    /*public function testRemoveTask(): void
    {
        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTasks());
    }*/

}