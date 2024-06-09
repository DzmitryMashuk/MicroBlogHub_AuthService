<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\RegistrationRequest;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly RegistrationService $registrationService
    ) {
    }

    #[Route('/api/v1/login', methods: ['POST'])]
    public function login(AuthenticationUtils $authenticationUtils)
    {
    }

    #[Route('/api/v1/registration', methods: ['POST'])]
    public function registration(#[RequestBody] RegistrationRequest $registrationRequest): JsonResponse
    {
        return $this->json($this->registrationService->registration($registrationRequest));
    }

    #[Route('/api/v1/is_auth', methods: ['GET'])]
    public function isAuth(?UserInterface $user = null): JsonResponse
    {
        return $this->json($user instanceof UserInterface);
    }

    #[Route('/api/v1/logout', methods: ['POST'])]
    public function logout(TokenStorageInterface $tokenStorage): JsonResponse
    {
        $tokenStorage->setToken();

        return new JsonResponse(['message' => 'You have been successfully logged out.'], JsonResponse::HTTP_OK);
    }
}
