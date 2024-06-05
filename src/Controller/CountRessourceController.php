<?php

namespace App\Controller;

use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CountRessourceController extends AbstractController
{
    public function __construct(
        private readonly RessourceRepository $repository
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $all = $this->repository->createQueryBuilder("r")
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $categories = $this->repository->createQueryBuilder('r')
            ->select('c.title AS category_name, COUNT(r.id) AS ressource_count')
            ->join('r.ressourceCategory', 'c')
            ->groupBy('c.title')
            ->getQuery()
            ->getResult();

        return new JsonResponse(['all' => $all, 'byCategories' => $categories], 200);
    }

}