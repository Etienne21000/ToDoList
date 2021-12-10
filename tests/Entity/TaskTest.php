<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function createTask(): Task
    {
        $user = UserRepository::class->findOneBy(["id" => 1]);
        return $task = (new Task())
            ->setTitle('TestCaseTask')
            ->setContent('We test the unitary task')
            ->setIsDone(0)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());
    }

    public function assertKernet(Task $task, int $number = 0){
        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount($number, $error);
    }

    public function testGetSingleTask() {
        $this->assertKernet($this->createTask(), 0);
    }

    public function testInvalidTask() {
        $task = ($this->createTask())
            ->setTitle('');
        $this->assertKernet($task, 1);
    }

    public function testTaskMultipleInvalid() {
        $task = ($this->createTask())
            ->setContent('')
            ->setIsDone('')
            ->setCreatedAt(null);
        $this->assertKernet($task, 3);
    }

    public function testInvalidUserTask() {
        $user = UserRepository::class->findOneBy(["id" => 100]);
        $task = ($this->createTask())
            ->setUser($user);
        $this->assertKernet($task, 1);
    }

    public function testInvalidNullUser() {
        $task = ($this->createTask())
            ->setUser(null);
        $this->assertKernet($task, 1);
    }

}