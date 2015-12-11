<?php

namespace Phamily\Framework\Repository;

use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterInterface;

/**
 * Repositories layer super class.
 *
 * @author samizdam
 *
 */
abstract class AbstractRepository implements RepositoryInterface
{
    protected $adapter;

    /**
     *
     * @param unknown $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    protected function getRowGatewayInstance()
    {
        return new RowGateway($this->primaryKey, $this->tableName, $this->adapter);
    }

    protected function createTableGateway($tableName, $f = [])
    {
        return new TableGateway($tableName, $this->adapter, $f);
    }

    protected function factory($repositoryType = __CLASS__)
    {
        return new $repositoryType($this->adapter);
    }
}
