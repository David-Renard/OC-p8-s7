<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{


    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $manager,
    ) {}

    #[Route('/', name: 'list')]
    public function listAction(): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function createAction(Request $request): Response
    {
        if ($this->getUser()) return $this->redirectToRoute('homepage');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

            $user->eraseCredentials();
            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash("success", "Votre compte a bien été créé! Vous pouvez dès maintenant vous connecter.");

            return $this->redirectToRoute("app_login");
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView(),]);
    }
}
