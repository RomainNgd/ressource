<?php

namespace App\Controller;

use App\Repository\FavoriteRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyFavoriteController extends AbstractController
{

    public function __construct(
        private readonly FavoriteRepository $favoriteRepository,
        private readonly AuthService $authService,
    )
    {
    }

    public function __invoke(): array
    {
        $ressources = [];
        $favorites = $this->favoriteRepository->findBy(['user' => $this->authService->getCurrentUser()]);
        foreach ($favorites as $favorite) {

            $ressources[] =[ $favorite, $favorite->getRessource()];
        }
        return $ressources;
    }
}