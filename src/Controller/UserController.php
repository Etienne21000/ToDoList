<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var UserPasswordHasherInterface
     */
    private $encodePass;

    public function __construct(UserRepository $user, EntityManagerInterface $manager, UserPasswordHasherInterface $encodePass)
    {
        $this->manager = $manager;
        $this->repository = $user;
        $this->encodePass = $encodePass;
    }

    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
        $user = new User();
        if($this->isGranted(UserVoter::CREATE, $user)){
            return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('App:User')->findAll()]);
        } else {
            $this->addFlash('error', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/users/create", name="user_create")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        if($this->isGranted(UserVoter::CREATE, $user)){
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordHasher->hashPassword($user, $user->getPassword());

                $user->setPassword($password);
                $user->setRoles($user->getRoles());

                $this->manager->persist($user);
                $this->manager->flush();

                $this->addFlash('success', "L'utilisateur a bien été ajouté.");

                return $this->redirectToRoute('user_list');
            }
        } else {
            $this->addFlash('error', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @param int $id
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $user = $this->repository->findOneBy(["id" => $id]);
        $form = $this->createForm(UserType::class, $user);

        if($this->isGranted(UserVoter::EDIT, $user)){
            $form->handleRequest($request);
            $password = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles($user->getRoles());
                $this->manager->persist($user);
                $this->manager->flush();
                $this->addFlash('success', "L'utilisateur a bien été modifié");
                return $this->redirectToRoute('user_list');
            }
        } else {
            $this->addFlash('error', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
