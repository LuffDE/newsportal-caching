<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CacheControlSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.response' => 'onKernelResponse'
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        if ($event->getRequest()->isMethodCacheable()) {
            if (!$response->headers->has('Cache-Control')) {
                $response->headers->set('Cache-Control', 'public, s-maxage=3600');
            }
        }
    }
}