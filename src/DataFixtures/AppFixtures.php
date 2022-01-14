<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
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
            'OpenClassrooms75!'
        ));

        $user_admin = (new User())
            ->setPseudo('Amdin')
            ->setEmail('admin@mail.com')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user_admin);
        $user_admin->setPassword($this->passwordHasher->hashPassword(
            $user_admin,
            'OpenClassrooms75!'
        ));

        $etienne = (new User())
            ->setPseudo('Etienne')
            ->setEmail('etienne@mail.com')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($etienne);
        $etienne->setPassword($this->passwordHasher->hashPassword(
            $etienne,
            'OpenClassrooms75!'));

        $userParams = [$user, $user_admin, $etienne];
        $isDoneParams = [0, 1];

        for($i = 0; $i < 20; $i++) {
            $title = $faker->realText($maxNbChars = 20, $indexSize = 2);
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