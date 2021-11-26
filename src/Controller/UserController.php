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
        //add condition on user role if admin add field select role in twig view
        $user->setRoles(['ROLE_ADMIN']);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordHasher->hashPassword($user, $user->getPassword());

            $user->setPassword($password);

            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->manager->persist($user);
            $this->manager->flush();

//            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
