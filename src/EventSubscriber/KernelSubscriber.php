<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface
{

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // Vérifie si la requête est faite pour la page /API
        if ($path === '/api/docs') {
            return;
        }
        // Vérifie si la clé API est présente dans l'en-tête
        if ($request->headers->get('X-API-Key') !== $this->apiKey) {
            throw new AccessDeniedException('Invalid API key');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1024],
        ];
    }
}
