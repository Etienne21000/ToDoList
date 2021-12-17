<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    private $task;

    private $user;

    private $date;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->user = new User();
        $this->date = new \DateTime();
    }

    public function testTaskTitle(): void
    {
        $title = 'ma nouvelle tâche';
        $this->task->setTitle($title);
        $this->assertSame("ma nouvelle tâche", $this->task->getTitle());
    }

    public function testTaskContent(): void
    {
        $content = "Le contenu de ma nouvelle tâche";
        $this->task->setContent($content);
        $this->assertSame("Le contenu de ma nouvelle tâche", $this->task->getContent());
    }

    public function testTaskId(): void
    {
        //$id = 1;
        $this->assertNull($this->task->getId());
    }

    public function testTaskIsDone(): void
    {
        $isDone = false;
        $this->assertSame($isDone, $this->task->getIsDone());
    }

    public function testTaskUser(): void
    {
        $this->task->setUser($this->user);
        $this->assertSame($this->user, $this->task->getUser());
    }

    public function testTaskEmptyTitle(): void
    {
        $title = "";
        $this->task->setTitle($title);
        $this->assertSame($title, $this->task->getTitle());
    }

    Public function testTaskErrorUserRole(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->task->setUser($this->user);
        $this->assertNotSame($this->user->setRoles(['ROLE_ADMIN']), $this->task->getUser()->getRoles());
    }

    public function testTaskErrorOnFakeId(): void
    {
        $taskId = 100;
        $this->assertNotEquals($taskId, $this->task->getId());
    }

    public function testTaskCreatedAt(): void
    {
        $this->task->setCreatedAt($this->date);
        $this->assertSame($this->date, $this->task->getCreatedAt());
    }

    public function testTaskModifiedAt(): void
    {
        $this->task->setModifiedAt($this->date);
        $this->assertSame($this->date, $this->task->getModifiedAt());
    }
}