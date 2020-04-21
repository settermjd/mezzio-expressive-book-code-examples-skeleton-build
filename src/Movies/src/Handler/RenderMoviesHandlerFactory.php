<?php

namespace Movies\Handler;

use Interop\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;

class RenderMoviesHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return RenderMoviesHandler
     */
    public function __invoke(ContainerInterface $container) : RenderMoviesHandler
    {
        $movieData = $container->has('MovieData')
            ? $container->get('MovieData')
            : null;
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new RenderMoviesHandler($movieData, $router, $template);
    }
}
