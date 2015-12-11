<?php

namespace Phamily\Framework\Repository;

use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\RowGateway\RowGatewayInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

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
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     *
     * @return RowGatewayInterface
     */
    protected function getRowGatewayInstance()
    {
        return new RowGateway($this->primaryKey, $this->tableName, $this->adapter);
    }

    /**
     *
     *
     * @param string $tableName
     * @param array $features
     * @return TableGatewayInterface
     */
    protected function createTableGateway($tableName, $features = [])
    {
        return new TableGateway($tableName, $this->adapter, $features);
    }

    /**
     *
     *
     * @param string $repositoryType
     * @return AbstractRepository
     */
    protected function factory($repositoryType = __CLASS__)
    {
        return new $repositoryType($this->adapter);
    }
}
