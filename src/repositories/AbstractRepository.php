<?php
namespace phamily\framework\repositories;

use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;

abstract class AbstractRepository implements RepositoryInterface
{

    protected $adapter;

    public function __construct($adapter)
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