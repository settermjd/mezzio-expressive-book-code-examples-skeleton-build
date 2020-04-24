<?php

namespace Movies\Handler;

use Interop\Container\ContainerInterface;
use Mezzio\MiddlewareFactory;
use Movies\Middleware\SecureAccessPipelineTrait;

class RenderMoviesHandlerPipelineWithTraitFactory
{
    use SecureAccessPipelineTrait;

    public function __invoke(ContainerInterface $container)
    {
        $factory = $container->get(MiddlewareFactory::class);
        
        $pipeline = $this->createPipeline($container);
        $pipeline->pipe($factory->prepare(RenderMoviesHandler::class));

        return $pipeline;
    }
}
