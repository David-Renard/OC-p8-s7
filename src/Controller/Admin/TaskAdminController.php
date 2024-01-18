<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/task', name: 'admin_task_')]
#[IsGranted('ROLE_ADMIN')]
class TaskAdminController extends AbstractController
{


    public function __construct(private readonly TaskRepository $taskRepository, private readonly EntityManagerInterface $manager) {}

    #[Route('/', name: 'list')]
    public function indexAnonymousTasksAction(): Response
    {
        $tasks = $this->taskRepository->findAnonymousTasks(false);

        return $this->render('admin/task/opened.html.twig', ['tasks' => $tasks]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'])]
    public function deleteAnonymousTasksAction(Task $task): Response
    {
        $this->manager->remove($task);
        $this->manager->flush();

        $this->addFlash("success", "Cette tâche a bien été supprimée.");

        return $this->redirectToRoute('admin_task_list');
    }
}