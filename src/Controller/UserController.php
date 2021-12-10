<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('App:User')->findAll()]);
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
        $this->denyAccessUnlessGranted('create', $user);
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
        $this->denyAccessUnlessGranted('edit', $user);
        $form = $this->createForm(UserType::class, $user);
//        dd($user->getPassword()); die();
        $userPass = $form->get('password')->getData();
//        if(!empty($userPass)) {
            $password = $passwordHasher->hashPassword($user, $userPass);
            $user->setPassword($password);
//            //$user->setPassword($user->getPassword());
//        }
        //dd($userPass);
        /*if(!empty($form->get('roles')->getData())) {
            $user->removeRole($role);
        }*/
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($user->getRoles());
            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
