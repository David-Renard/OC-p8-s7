<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/user', name: 'admin_user_')]
#[IsGranted('ROLE_ADMIN')]
class UserAdminController extends AbstractController
{


    public function __construct
    (
        private readonly UserRepository $userRepository,
        private readonly TaskRepository $taskRepository,
        private readonly EntityManagerInterface $manager,
    )
    {
    }


    /**
     * allow an admin to see all anonymous tasks (done or not)
     * @return Response
     */
    #[Route('/', name: 'list')]
    public function indexAdminUsersAction(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/user/index.html.twig', ['users' => $users]);

    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'])]
    public function deleteUserAction(User $user): Response
    {
        $this->anonymiseTasks($user);

        $this->manager->remove($user);
        $this->manager->flush();

        $this->addFlash("success", "L'utilisateur a bien été supprimé.");

        return $this->redirectToRoute('admin_user_list');

    }

    #[Route('/edit/{id}', name: 'edit', requirements:  ['id' => '\d+'])]
    public function editUserAction(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDIT', $user);
        $form = $this->createForm(AdminUserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($form->get('roles')->getData());
            $this->manager->flush($user);

            $this->addFlash("success", "Le rôle de l'utilisateur a bien été modifié.");
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render(
                                'admin/user/edit.html.twig',
                                [
                                    'form' => $form->createView(),
                                    'user' => $user,
                                ]
                            );

    }

    /**
     * private function used to anonymise all tasks from a user when deleted
     * @param $user
     * @return void
     */
    private function anonymiseTasks($user): void
    {
        $tasks = $this->taskRepository->findBy(['author' => $user,]);

        foreach ($tasks as $task) {
            $task->setAuthor(null);
        }
        $this->manager->flush();

    }
}