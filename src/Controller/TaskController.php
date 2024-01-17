<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{


    public function __construct(private readonly TaskRepository $taskRepository, private readonly EntityManagerInterface $manager)
    {
    }

    #[Route('/{page}', name: 'task_list', requirements: ['page' => '\d+'])]
    public function listUncheckedTask(?int $page = 1): Response
    {
        $tasks = $this->getOtherStatusTasks($page, false);

        if ($tasks === []) return $this->redirectToRoute('app_login');

        return $this->render('task/opened.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/{page}/closed', name: 'task_closed', requirements: ['page' => '\d+'])]
    public function listCheckedTask(?int $page = 1): Response
    {
        $tasks = $this->getOtherStatusTasks($page, true);

        if ($tasks === []) return $this->redirectToRoute('app_login');

        return $this->render('task/closed.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/create', name: 'task_create')]
    public function createTask(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($this->getUser());

            $this->manager->persist($task);
            $this->manager->flush();

            $this->addFlash("succes", "La tâche a bien été ajoutée.");

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'task_update', requirements: ['id' => '\d+'])]
    public function updateTask(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setTitle($form->get('title')->getData());
            $task->setContent($form->get('content')->getData());

            $this->manager->flush();
            $this->addFlash("success", "La tâche a bien été modifiée.");

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'task_delete', requirements: ['id' => '\d+'])]
    public function deleteTask(Task $task): Response
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task);
        $this->manager->remove($task);
        $this->manager->flush();

        $this->addFlash("success", "La tâche a bien été supprimée.");

        return $this->redirectToRoute('task_list');
    }

    #[Route('/{id}/toggle', name: 'task_toggle', requirements: ['id' => '\d+'])]
    public function toggleTask(Task $task): Response
    {
        $task->isIsDone() ? $task->setIsDone(false) : $task->setIsDone(true);

        $this->manager->flush($task);
        $task->isIsDone() ? $this->addFlash("success", sprintf("La tâche '%s' est désormais terminée.", $task->getTitle())) : $this->addFlash("success", sprintf("La tâche '%s' est désormais ouverte.", $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    private function getOtherStatusTasks(int $page, bool $isDone): array
    {
        $tasks = [];
        $author = $this->getUser();

        if ($author === null) return $tasks;

        if (!in_array('ROLE_ADMIN', $author->getRoles()))
        {
            $tasks = $this->taskRepository->findAllTasks($page, $isDone, '', $author->getUsername());
        }
        else {
            $tasks = $this->taskRepository->findAllTasks($page, $isDone, 'anonymous', $author->getUsername());
        }

        return $tasks;
    }
}