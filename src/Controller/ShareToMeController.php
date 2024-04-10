<?php

namespace App\Controller;

use App\Repository\ShareRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShareToMeController extends AbstractController
{

    public function __construct(
        private readonly ShareRepository $shareRepository,
        private readonly AuthService $authService,
    )
    {
    }

    public function __invoke(): array
    {
        return $this->shareRepository->findBy(['recipient' => $this->authService->getCurrentUser()]);
    }

}