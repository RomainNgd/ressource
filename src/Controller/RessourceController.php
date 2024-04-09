<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class RessourceController extends AbstractController
{

    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    public function __invoke(Ressource $ressource): Ressource
    {
        if (!$ressource->getTitle() || !$ressource->getDescription() || !$ressource->getContent()){
            throw new InvalidParameterException();
        }
        $ressource->setUser($this->authService->getCurrentUser());
        $ressource->setAccepted(false);
        $ressource->setUpdateAt(new \DateTime());

        return $ressource;
    }

}