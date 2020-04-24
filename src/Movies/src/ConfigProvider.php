<?php

declare(strict_types=1);

namespace Movies;

use Mezzio\Application;
use Mezzio\Container\ApplicationConfigInjectionDelegator;
use Movies\Handler\RenderMoviesHandler;
use Movies\Handler\RenderMoviesHandlerFactory;
use Movies\Handler\RenderMoviesHandlerPipeline;
use Movies\Handler\RenderMoviesHandlerPipelineWithTraitFactory;
use Movies\Middleware\AuthenticationMiddleware;
use Movies\Middleware\AuthorizationMiddleware;
use Movies\Services\Database\MovieTable;
use Movies\Services\Database\MovieTableFactory;
use Movies\Services\Database\TableAbstractFactory;
use Movies\Services\Database\TableGatewayAbstractFactory;
use Movies\Services\FileMovieDataService;

/**
 * The configuration provider for the Movies module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes'       => $this->getRoutes(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'abstract_factories' => [
                TableAbstractFactory::class,
                TableGatewayAbstractFactory::class,
            ],
            'delegators' => [
                Application::class => [
                    ApplicationConfigInjectionDelegator::class,
                ],
            ],
            'factories'  => [
                MovieTable::class => MovieTableFactory::class,
                RenderMoviesHandler::class => RenderMoviesHandlerFactory::class,
                RenderMoviesHandlerPipeline::class => RenderMoviesHandlerPipeline::class,
                RenderMoviesHandlerPipelineWithTraitFactory::class => RenderMoviesHandlerPipelineWithTraitFactory::class
            ],
            'invokables' => [
                'MovieData' => FileMovieDataService::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'movies'    => [__DIR__ . '/../templates/movies'],
            ],
        ];
    }

    public function getRoutes() : array
    {
        return [
            [
                'path'            => '/',
                'name'            => 'home',
                'middleware'      => [
                    RenderMoviesHandlerPipelineWithTraitFactory::class
                ],
                'allowed_methods' => ['GET'],
            ],
        ];
    }
}
