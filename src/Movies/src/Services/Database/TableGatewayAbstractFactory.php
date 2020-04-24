<?php

namespace Movies\Services\Database;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Movies\Entities\Movie;
use Interop\Container\ContainerInterface;

/**
 * Class TableGatewayAbstractFactory
 * @package Movies\Services\Database
 */
class TableGatewayAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (fnmatch('*TableGateway', $requestedName)) {
            return true;
        }

        return false;
    }

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return object|TableGateway|null
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get(Adapter::class);
        $tableGateway = null;

        if ($requestedName === 'Movies\Services\Database\MovieTableGateway') {
            $hydrator = new ClassMethodsHydrator();
            $hydrator->setNamingStrategy(
                MapNamingStrategy::createFromHydrationMap(
                    [
                        'director' => 'director',
                        'genre' => 'genre',
                        'release_date' => 'releaseDate',
                        'stars' => 'stars',
                        'synopsis' => 'synopsis',
                        'title' => 'title',
                    ]
                )
            );

            $tableGateway = new TableGateway(
                'tblmovies',
                $dbAdapter,
                null,
                new HydratingResultSet($hydrator, new Movie())
            );
        }

        return $tableGateway;
    }
}
