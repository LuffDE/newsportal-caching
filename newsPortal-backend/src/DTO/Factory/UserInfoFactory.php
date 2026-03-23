<?php

namespace App\DTO\Factory;

use App\DTO\UserInfo;
use App\Entity\User;
use App\Exception\MissingDataException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

class UserInfoFactory
{
    /**
     * @throws ReflectionException
     * @throws MissingDataException
     */
    public static function createFromRequest(Request $request): UserInfo
    {
        $data = $request->getPayload();
        $info = [
            'email' => $data->get('email'),
            'password' => $data->get('password'),
            'firstName' => $data->get('firstName'),
            'lastName' => $data->get('lastName'),
            'dateOfBirth' => $data->get('dateOfBirth'),
        ];
        $userInfo = new UserInfo();
        Hydrator::hydrate($userInfo, $info);
        if (empty($userInfo->getEmail())) {
            throw new MissingDataException();
        }
        return $userInfo;
    }

    public static function createFromUser(User $user): UserInfo
    {
        $userInfo = new UserInfo();
        $userInfo->setEmail($user->getEmail());
        $userInfo->setFirstName($user->getFirstName());
        $userInfo->setLastName($user->getLastName());
        $userInfo->setDateOfBirth($user->getDateOfBirth());
        $userInfo->setStreet($user->getStreet());
        $userInfo->setHouseNumber($user->getHouseNumber());
        return $userInfo;
    }
}