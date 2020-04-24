<?php

namespace Movies\Handler;

use Interop\Container\ContainerInterface;
use Laminas\Stratigility\MiddlewarePipe;
use Mezzio\MiddlewareFactory;
use Movies\Middleware\AuthenticationMiddleware;
use Movies\Middleware\AuthorizationMiddleware;

class RenderMoviesHandlerPipeline
{
    public function __invoke(ContainerInterface $container)
    {
        $factory = $container->get(MiddlewareFactory::class);
        $pipeline = new MiddlewarePipe();

        $pipeline->pipe($factory->prepare(AuthenticationMiddleware::class));
        $pipeline->pipe($factory->prepare(AuthorizationMiddleware::class));
        $pipeline->pipe($factory->prepare(RenderMoviesHandler::class));

        return $pipeline;
    }
}
