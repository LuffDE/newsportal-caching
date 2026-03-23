<?php

namespace App\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class UserInfo extends AbstractJson
{
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email = null;

    #[Assert\NotBlank()]
    #[Assert\PasswordStrength]
    private ?string $password = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $street = null;
    private ?string $houseNumber = null;
    private ?DateTimeInterface $dateOfBirth = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): UserInfo
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): UserInfo
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): UserInfo
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): UserInfo
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): UserInfo
    {
        $this->street = $street;
        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): UserInfo
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?DateTimeInterface $dateOfBirth): UserInfo
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }


    public function toJsonArray(): void
    {
        parent::setup(get_object_vars($this));
    }
}