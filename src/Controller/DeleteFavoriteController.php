<?php

namespace App\Controller;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Entity\Favorite;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteFavoriteController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(Favorite $favorite): void
    {
        if ($favorite->getUser() !== $this->authService->getCurrentUser()){
            throw new AccessDeniedException();
        } else{
            $this->entityManager->remove($favorite);
            $this->entityManager->flush();
        }
    }
}