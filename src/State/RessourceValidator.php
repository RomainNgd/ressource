<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Ressource;
use Symfony\Bundle\SecurityBundle\Security;
use Vich\UploaderBundle\Storage\StorageInterface;

class RessourceValidator implements ProcessorInterface
{

    public function __construct(
        private readonly Security $security,
        private readonly StorageInterface $storage,
    )
    {
    }

    /**
     * @param Ressource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Ressource
    {
        if (!$data->getTitle() || !$data->getDescription() || !$data->getContent()){
            return $this->process($data, $operation, $uriVariables, $context);
        }
        $data->setTitle($this->security->getUser()->getUserIdentifier());
        $data->setAccepted(false);
        $data->setUpdateAt(new \DateTime());
        if ($data->getFile()){
            $data->setFileUrl( $this->storage->resolveUri($data, 'file'));
        }


        return $this->process($data, $operation, $uriVariables, $context);

    }
}
