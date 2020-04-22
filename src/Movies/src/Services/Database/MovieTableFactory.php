<?php


namespace Movies\Services\Database;

use Interop\Container\ContainerInterface;

class MovieTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MovieTable(
            $container->get(
                'Movies\Services\Database\MovieTableGateway'
            )
        );
    }
}
