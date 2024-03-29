<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmptyController extends AbstractController
{

    public function __invoke($date)
    {
        //empty Controller
        return $date;
    }
}