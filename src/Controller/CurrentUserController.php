<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;

class CurrentUserController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
    )
    {
    }

    public function __invoke(): User
    {
        return $this->authService->getCurrentUser();
    }
}