<?php

namespace App\Controller;

use App\Repository\RessourceRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyRessourceController extends AbstractController
{

    public function __construct(
        private readonly AuthService $authService,
        private readonly RessourceRepository $ressourceRepository,
    )
    {
    }

    public function __invoke(): array
    {
        $user = $this->authService->getCurrentUser();
        return $this->ressourceRepository->findBy(['user' => $user]);
    }

}