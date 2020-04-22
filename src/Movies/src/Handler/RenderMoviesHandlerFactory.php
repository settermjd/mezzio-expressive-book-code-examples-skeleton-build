<?php

namespace Movies\Handler;

use Interop\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Movies\Services\Database\MovieTable;

class RenderMoviesHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return RenderMoviesHandler
     */
    public function __invoke(ContainerInterface $container) : RenderMoviesHandler
    {
        $movieData = $container->has(MovieTable::class)
            ? $container->get(MovieTable::class)
            : null;
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new RenderMoviesHandler($movieData, $router, $template);
    }
}
