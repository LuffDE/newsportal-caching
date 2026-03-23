<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

//    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $email = $request->getPayload()->get('email');
        $password = $request->getPayload()->get('password');

        if (empty($email) || empty($password)) {
            return new Response('Email or password is empty', Response::HTTP_BAD_REQUEST);
        }
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (empty($user)) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }
        if (!$hasher->isPasswordValid($user, $password)) {
            return new Response('Invalid password', Response::HTTP_UNAUTHORIZED);
        }
    }
}