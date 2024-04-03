<?php

namespace App\Serializer;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class FileDenormalizer implements DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): File
    {
        return $data;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $data instanceof File;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object'=> null,
            '*' => false,
            File::class => true,
        ];
    }
}