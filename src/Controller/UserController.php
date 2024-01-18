<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{


    public function __construct(private readonly UserRepository $userRepository) {}
    #[Route('/', name: 'list')]
    public function listAction(): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }

//    #[Route('/create', name: 'create')]
//    public function createAction(Request $request)
}
