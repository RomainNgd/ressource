<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Ressource;

class RessourceValidator implements ProcessorInterface
{
    /**
     * @param Ressource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Ressource
    {
        if (!$data->getTitle() || !$data->getDescription() || !$data->getContent()){
            return $this->process($data, $operation, $uriVariables, $context);
        }
        $data->setAccepted(false);
        $data->setUpdateAt(new \DateTime());

        return $this->process($data, $operation, $uriVariables, $context);

    }
}
