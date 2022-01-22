<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Security\Voter\TaskVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var TaskRepository
     */
    private $repository;

    public function __construct(TaskRepository $repository, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('App:Task')->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request): ?Response
    {
        $task = new Task();
        $user = $this->getUser();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        $task->setUser($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($task);
            $this->manager->flush();
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function editAction(int $id, Request $request)
    {
        $task = $this->repository->findOneBy(["id" => $id]);
        $title = $task->getTitle();
        $form = $this->createForm(TaskType::class, $task);

        if($this->isGranted(TaskVoter::EDIT, $task) === true) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $task->setModifiedAt(new \DateTime('now'));
                $this->manager->persist($task);
                $this->manager->flush();
                $this->addFlash('success', 'La tâche ' . $title . ' a bien été modifiée.');
                return $this->redirectToRoute('task_list');
            }
        } else {
            $this->addFlash('error', 'Vous ne pouvez pas modifier la tâche '.$title.' car vous n\'en êtes pas l\'auteur');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @param int $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function toggleTaskAction(int $id)
    {
        $task = $this->repository->findOneBy(['id' => $id]);
        $title = $task->getTitle();
        $task->toggle(!$task->isDone());
        $task->setModifiedAt(new \DateTime('now'));

        $this->manager->persist($task);
        $this->manager->flush();

        $this->addFlash('success', sprintf('La tâche '.$title.' a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteTaskAction(int $id)
    {
        $task = $this->repository->findOneBy(['id' => $id]);
        $title = $task->getTitle();
        if($this->isGranted(TaskVoter::DELETE, $task) === true){
            $this->manager->remove($task);
            $this->manager->flush();
            $this->addFlash('success', 'La tâche '.$title.' a bien été supprimée.');
            return $this->redirectToRoute('task_list');
        } else {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer la tâche '.$title.' car vous n\'en êtes pas l\'auteur');
            return $this->redirectToRoute('task_list');
        }
    }
}
