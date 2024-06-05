<?php

namespace App\Serializer;

use App\Entity\Comment;
use App\Entity\Favorite;
use App\Entity\Ressource;
use App\Repository\FavoriteRepository;
use App\Service\AuthService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

class RessourceNormalizer implements NormalizerInterface
{

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer,
        private readonly StorageInterface $storage,
        private readonly FavoriteRepository $favoriteRepository,
        private readonly AuthService $authService,
    ) {
    }

    /**
     * @param Ressource $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        if ($object->getFilePath()){
            $object->setFileUrl( $this->storage->resolveUri($object, 'file'));
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        if ($data instanceof Ressource){
            $isFavorite = $this->favoriteRepository->findOneBy(['ressource' => $data->getId(), 'user' => $this->authService->getCurrentUser()->getId()]);
            if ($isFavorite instanceof Favorite){
                $data->setIsFavorite(true);
            } else{
                $data->setIsFavorite(false);
            }
        }

        return $data instanceof Ressource;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Ressource::class => true,
        ];
    }
}