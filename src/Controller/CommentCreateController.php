<?php

namespace App\Controller;

use ApiPlatform\Exception\InvalidIdentifierException;
use App\Entity\Comment;
use App\Entity\User;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentCreateController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
    )
    {
    }

    public function __invoke(Comment $data): Comment
    {
        if (!$data->getRessource()->isAccepted() || !$data->getRessource()->isVisible())
        {
            throw new InvalidIdentifierException('La ressource communiqué ne peut pas recevoir de commentaire');
        }
        $data->setUser($this->authService->getCurrentUser());
        return $data;
    }

}