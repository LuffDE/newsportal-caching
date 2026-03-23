<?php

namespace App\Controller;

use App\DTO\Factory\UserInfoFactory;
use App\DTO\UserInfo;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

final class RegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/api/register", name: "register", methods: ["POST"])]
    public function register(Request $request, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher, Security $security): JsonResponse
    {
        try {
            // create intermediate DTO for validation/assertion
            $userInfo = UserInfoFactory::createFromRequest($request);
        } catch (Throwable $e) {
            (new Logger('app'))->error($e->getMessage());
            $userInfo = new UserInfo();
        }

        $errors = $validator->validate($userInfo);

        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                ];
            }
            return new JsonResponse($messages, Response::HTTP_BAD_REQUEST);
        }
        $duplicate = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $userInfo->getEmail()]);
        if (!empty($duplicate)) {
            return new JsonResponse(['message' => 'User already exists.'], Response::HTTP_BAD_REQUEST);
        }
        $user = new User();
        $user->setEmail($userInfo->getEmail());
        $user->setFirstName($userInfo->getFirstName());
        $user->setLastName($userInfo->getLastName());
        $user->setPassword($passwordHasher->hashPassword($user, $userInfo->getPassword()));
        $user->setDateOfBirth($userInfo->getDateOfBirth());
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'User successfully created'], Response::HTTP_CREATED);
    }
}