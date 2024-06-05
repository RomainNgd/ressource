<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FavoriteController extends AbstractController
{

    public function __construct(
        private readonly AuthService $authService,
        private readonly FavoriteRepository $favoriteRepository,
    )
    {
    }

    public function __invoke(Favorite $favorite): Favorite
     {
         $currentUser = $this->authService->getCurrentUser();
         $already = $this->favoriteRepository->findOneBy(['user' => $currentUser, 'ressource' => $favorite->getRessource()]);
         if ($already instanceof Favorite){
             throw new HttpException(312, 'Already in favorite');
         }
         $favorite->setUser($currentUser);
         return $favorite;
     }

}