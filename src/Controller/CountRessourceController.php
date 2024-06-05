<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CountRessourceController extends AbstractController
{
    public function __construct(
        private readonly RessourceRepository $repository,
        private readonly CommentRepository $commentRepository,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $commentsByDay = $this->commentRepository->countCommentLastFiveDays();
        $ressourceByDay = $this->repository->countRessourcesLastFiveDays();
        $all = $this->repository->countTotalRessources();
        $categories = $this->repository->countRessourcesByCategory();

        return new JsonResponse([
            'countAllRessource' => $all,
            'ressourceByCategories' => $categories,
            'ressourceByDays' => $ressourceByDay,
            'commentByDays' => $commentsByDay,
        ], 200);
    }

}