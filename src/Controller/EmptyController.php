<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmptyController extends AbstractController
{

    public function __invoke($data)
    {
        //empty Controller
        return $data;
    }
}