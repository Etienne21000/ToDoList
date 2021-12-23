<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager) {
        $faker = Faker\Factory::create('fr_FR');

        $user = (new User())
            ->setPseudo('Max')
            ->setEmail('max@mail.com')
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'OpenClassrooms21!'
        ));

        $user_admin = (new User())
            ->setPseudo('Amdin')
            ->setEmail('admin@mail.com')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user_admin);
        $user_admin->setPassword($this->passwordHasher->hashPassword(
            $user_admin,
            'OpenClassrooms21!'
        ));

        $userParams = [$user, $user_admin];
        $isDoneParams = [0, 1];

        for($i = 0; $i < 30; $i++) {
            $title = $faker->title;
            $content = $faker->text();
            $userShuffled = $this->shuffle($userParams);
            $isDone = $this->shuffle($isDoneParams);
            $task = (new Task())
                ->setUser($userShuffled)
                ->setCreatedAt(new \DateTime())
                ->setTitle($title)
                ->setContent($content)
                ->setIsDone($isDone);
            $manager->persist($task);
        }
        $manager->flush();
    }

    public function shuffle($params)
    {
        shuffle($params);
        foreach ($params as $param) {
            $resp = $param;
        }
        return $resp;
    }

}