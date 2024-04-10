<?php
namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\dto\ShareDto;
use App\Entity\Share;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class ShareProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly AuthService $authService,
        private readonly EntityManagerInterface $em,
    )
    {
    }

    /**
     * @param ShareDto $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Share
    {
        $sender = $this->authService->getCurrentUser();
        $receiver = $this->authService->getUser($data->getEmail());
        if ($sender === $receiver){
            throw new InvalidParameterException('Vous ne pouvez pas partager a vous même');
        }
        $share = new Share();
        $share->setRecipient($receiver);
        $share->setRessource($data->getRessource());
        $share->setSender($sender);
        $this->em->persist($share);
        $this->em->flush();

        return $share;
    }
}