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
        private readonly FavoriteRepository $favoriteRepository,
    )
    {
    }

    public function __invoke(Favorite $favorite): Favorite
     {
         $already = $this->favoriteRepository->createQueryBuilder('f')
             ->where('f.user = :user')
             ->andWhere('f.ressource = :ressource')
             ->setParameter('user', $favorite->getUser())
             ->setParameter('ressource', $favorite->getRessource())
             ->getQuery()->getResult();
         if ($already){
             throw new \Exception('La resource est déjà en favori');
         }
         if ($this->favoriteRepository->findBy(['']))
         $favorite->setUser($this->authService->getCurrentUser());
         return $favorite;
     }

}