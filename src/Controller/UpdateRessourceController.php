<?php

namespace App\Controller;

use App\dto\UpdateRessourceDto;
use App\Entity\Ressource;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UpdateRessourceController extends AbstractController
{

    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    public function __invoke(Ressource $ressource, Request $request)
    {
        var_dump($request->request->all());
        var_dump($request->files->get('file'));
        var_dump($ressource);
    }

}