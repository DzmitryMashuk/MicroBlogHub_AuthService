<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Model\RegistrationRequest;
use App\Model\UserResponse;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function registration(RegistrationRequest $registrationRequest): UserResponse
    {
        if ($this->userRepository->existsByEmail($registrationRequest->getEmail())) {
            throw new UserAlreadyExistsException();
        }

        $user = (new User())->setEmail($registrationRequest->getEmail());
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $registrationRequest->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new UserResponse($user->getId(), $user->getEmail(), $user->getCreatedAt(), $user->getUpdatedAt());
    }
}
