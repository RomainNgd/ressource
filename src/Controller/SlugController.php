<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SlugController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function __invoke(object $data) : object
    {
        if (!method_exists($data, 'setSlug') && !method_exists($data, 'getTitle')){
            throw new \Exception('Une erreur est survenue');
        } else {
            $data->setSlug(strtolower(str_replace(' ', '-', $data->getTitle())));
        }
        return $data;

    }

}