<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{

    public function __construct(
        private readonly AuthService $authService,
    )
    {
    }

    public function __invoke(Favorite $favorite): Favorite
     {
         $favorite->setUser($this->authService->getCurrentUser());
         return $favorite;
     }

}