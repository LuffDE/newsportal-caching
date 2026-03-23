<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\Factory\UserInfoFactory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private const string USER_NOT_FOUND_MESSAGE = 'User not found.';
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/api/user/profile', name: 'app_user_profile', methods: ['GET'])]
    public function profile(): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse(self::USER_NOT_FOUND_MESSAGE, Response::HTTP_FORBIDDEN);
        }

        $userInfo = UserInfoFactory::createFromUser($user);
        return new JsonResponse($userInfo);
    }

    #[Route('/api/user/update-profile', name: 'app_user_update_profile', methods: ['POST'])]
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse(self::USER_NOT_FOUND_MESSAGE, Response::HTTP_FORBIDDEN);
        }
        $userInfo = UserInfoFactory::createFromRequest($request);
        $user->setFirstName($userInfo->getFirstName());
        $user->setLastName($userInfo->getLastName());
        $user->setDateOfBirth($userInfo->getDateOfBirth());
        $user->setEmail($userInfo->getEmail());
        $user->setHouseNumber($userInfo->getHouseNumber());
        $user->setStreet($userInfo->getStreet());
        $this->manager->persist($user);
        $this->manager->flush();
        return new JsonResponse('Profile updated', Response::HTTP_OK);
    }

    #[Route('/api/user/delete-profile', name: 'app_user_delete_profile', methods: ['DELETE'])]
    public function deleteProfile(): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse(self::USER_NOT_FOUND_MESSAGE, Response::HTTP_FORBIDDEN);
        }
        $this->manager->remove($user);
        $this->manager->flush();
        return new JsonResponse('Profile deleted', Response::HTTP_OK);
    }

    #[Route('/api/user/change-password', name: 'app_user_change_password', methods: ['POST'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $hasher): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse(self::USER_NOT_FOUND_MESSAGE, Response::HTTP_FORBIDDEN);
        }
        $currentPassword = $request->getPayload()->get('currentPassword');
        $newPassword = $request->getPayload()->get('newPassword');
        $confirmPassword = $request->getPayload()->get('confirmPassword');
        if (!$hasher->isPasswordValid($user, $currentPassword) || $newPassword !== $confirmPassword) {
            return new JsonResponse('Passwords do not match.', Response::HTTP_UNAUTHORIZED);
        }

        $user->setPassword($hasher->hashPassword($user, $newPassword));
        $this->manager->persist($user);
        $this->manager->flush();
        return new JsonResponse('Password changed', Response::HTTP_OK);
    }

    #[Route('/api/user/category-preferences', name: 'app_user_category_preferences', methods: ['GET'])]
    public function userCategoryPreferences(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(self::USER_NOT_FOUND_MESSAGE, Response::HTTP_FORBIDDEN);
        }


    }

    public function updateUserCategoryPreferences(): JsonResponse
    {

    }


}