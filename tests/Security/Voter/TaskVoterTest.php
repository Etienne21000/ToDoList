<?php
//
//namespace App\Tests\Security\Voter;
//
//use App\Entity\Task;
//use App\Security\Voter\TaskVoter;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//
//class TaskVoterTest extends WebTestCase
//{
//   /* private $client;
//
//    private $task;
//
//    public function setUp(): void
//    {
//        $this->client = self::createClient();
//        $this->task = new Task();
//    }
//
//    public function logInUser(): void
//    {
//        $crawler = $this->client->request('GET', '/login');
//        $form = $crawler->selectButton('Sign in')->form();
//        $this->client->submit($form, ['email' => 'max@mail.com', 'password' => 'OpenClassrooms75!']);
//    }
//
//    public function loginAdmin(): void
//    {
//        $crawler = $this->client->request('GET', '/login');
//        $form = $crawler->selectButton('Sign in')->form();
//        $this->client->submit($form, ['email' => 'etienne@mail.com', 'password' => 'OpenClassrooms75!']);
//    }*/
//
//    /*public function testTaskUpdateAccessDenied(): void
//    {
//        $this->logInUser();
//        $this->client->request('GET', '/tasks/2/edit');
//        TaskVoter::ACCESS_DENIED;
//        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
//    }*/
//
//    /*public function testTaskUpdateVoter(): void
//    {
//        $this->loginAdmin();
//        $crawler = $this->client->request('POST', '/tasks/2/edit');
//        TaskVoter::ACCESS_GRANTED;
//        $form = $crawler->selectButton('Modifier')->form();
//        $form['task[title]'] = 'Test tache modification';
//        $form['task[content]'] = 'Test tache content modification';
//        $this->client->submit($form);
//        $crawler = $this->client->followRedirect();
//        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
//    }*/
//}