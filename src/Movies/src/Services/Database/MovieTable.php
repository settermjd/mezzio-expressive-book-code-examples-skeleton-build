<?php

namespace Movies\Services\Database;

use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\TableGateway\Exception\InvalidArgumentException;
use Laminas\Db\TableGateway\TableGateway;

/**
 * Class MovieTable
 * @package Movies\TableGateway
 */
class MovieTable
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Retrieve all movies
     *
     * @throws InvalidArgumentException
     * @return ResultSetInterface
     */
    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(
            [
                "title",
                "director",
                "release_date",
                "stars",
                "synopsis",
                "genre"
            ]
        )->order('title ASC');

        return  $this->tableGateway->selectWith($select);
    }
}
