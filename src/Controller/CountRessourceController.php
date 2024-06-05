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
        $all = $this->repository->countTotalRessources();
        $categories = $this->repository->countRessourcesByCategory();
        $ressourcesLastFiveDays = $this->repository->findRessourcesLastFiveDays();

        // Construire un tableau pour compter les ressources par jour
        $ressourcesCountByDay = [];
        $currentDate = new \DateTime('-4 days');
        for ($i = 0; $i < 5; $i++) {
            $ressourcesCountByDay[$currentDate->format('Y-m-d')] = 0;
            $currentDate->modify('+1 day');
        }

        foreach ($ressourcesLastFiveDays as $ressource) {
            $date = $ressource->getCreatedAt()->format('Y-m-d');
            if (isset($ressourcesCountByDay[$date])) {
                $ressourcesCountByDay[$date]++;
            } else {
                $ressourcesCountByDay[$date] = 1;
            }
        }

        return new JsonResponse([
            'countAllRessource' => $all,
            'ressourceByCategories' => $categories,
            'ressourceByDays' => $ressourcesCountByDay,
            'commentByDays' => $commentsByDay,
        ], 200);
    }

}