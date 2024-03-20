<?php
namespace App\Controller;

use App\Entity\Ressource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AcceptRessourceController extends AbstractController
{

    public function __invoke(Ressource $ressource): Ressource
    {
        $ressource->setAccepted(true);

        return $ressource;
    }

}