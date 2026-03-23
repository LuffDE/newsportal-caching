<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFixture
{
    private ObjectManager $manager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(ObjectManager $manager, UserPasswordHasherInterface $hasher)
    {
        $this->manager = $manager;
        $this->hasher = $hasher;
    }

    public function load(): void
    {
        $this->manager->persist($this->createAdmin());
        $this->manager->persist($this->createManagementUser());
        $this->manager->persist($this->createPremiumUser());
        $this->manager->persist($this->createUser());
        $this->manager->flush();
    }

    private function createAdmin(): UserInterface
    {
        $user = new User();
        $user->setEmail('admin@localhost');
        $user->setPassword($this->hasher->hashPassword($user, 'passwordAdmin'));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setDateOfBirth(new DateTime());
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setStreet('Musterstraße');
        $user->setHouseNumber("1");
        return $user;
    }

    private function createManagementUser(): UserInterface
    {
        $user = new User();
        $user->setEmail('management@localhost');
        $user->setPassword($this->hasher->hashPassword($user, 'passwordManagement'));
        $user->setRoles(['ROLE_MANAGEMENT']);
        $user->setDateOfBirth(new DateTime());
        $user->setFirstName('Management');
        $user->setLastName('Management');
        $user->setStreet('Musterstraße');
        $user->setHouseNumber("2");
        return $user;
    }

    private function createPremiumUser(): UserInterface
    {
        $user = new User();
        $user->setEmail('premium@localhost');
        $user->setPassword($this->hasher->hashPassword($user, 'passwordPremium'));
        $user->setRoles(['ROLE_PREMIUM']);
        $user->setDateOfBirth(new DateTime());
        $user->setFirstName('Premium');
        $user->setLastName('Premium');
        $user->setStreet('Musterstraße');
        $user->setHouseNumber("3");
        return $user;
    }

    private function createUser(): UserInterface
    {
        $user = new User();
        $user->setEmail('user@localhost');
        $user->setPassword($this->hasher->hashPassword($user, 'passwordUser'));
        $user->setRoles(['ROLE_USER']);
        $user->setDateOfBirth(new DateTime());
        $user->setFirstName('User');
        $user->setLastName('User');
        $user->setStreet('Musterstraße');
        $user->setHouseNumber("4");
        return $user;
    }
}