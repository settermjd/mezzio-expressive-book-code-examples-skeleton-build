<?php
namespace Movies\Middleware;

use Laminas\Stratigility\MiddlewarePipe;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

trait SecureAccessPipelineTrait
{
    private function createPipeline(ContainerInterface $container)
    {
        $factory = $container->get(MiddlewareFactory::class);
        $pipeline = new MiddlewarePipe();

        $pipeline->pipe($factory->prepare(AuthenticationMiddleware::class));
        $pipeline->pipe($factory->prepare(AuthorizationMiddleware::class));

        return $pipeline;
    }
}
