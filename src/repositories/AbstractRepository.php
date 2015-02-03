<?php
namespace phamily\framework\repositories;

use Zend\Db\RowGateway\RowGateway;
abstract class AbstractRepository implements RepositoryInterface{
	
	protected $adapter;
	
	public function __construct($adapter){
		$this->adapter = $adapter;
	}
	
	protected function getRowGatewayInstance(){
		return new RowGateway($this->primaryKey, $this->tableName, $this->adapter);
	}	
}