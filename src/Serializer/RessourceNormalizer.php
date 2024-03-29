<?php

namespace App\Serializer;

use App\Entity\Ressource;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Flex\Response;
use Vich\UploaderBundle\Storage\StorageInterface;

class RessourceNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'AppRessourceNormalizerAlreadyCalled';


    public function __construct(
        private readonly StorageInterface $storage,
    )
    {
    }

    /**
     * @param Ressource $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $object->setFileUrl($this->storage->resolveUri($object, 'file'));
        $context[self::ALREADY_CALLED] = true;
        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof Ressource;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [];
    }
}