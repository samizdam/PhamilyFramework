<?php
namespace phamily\framework\repositories;

use phamily\framework\models\AnthroponymInterface;
use Zend\Db\TableGateway\TableGateway;
use phamily\framework\models\Anthroponym;
class AnthroponymRepository extends AbstractRepository implements AnthroponymRepositoryInterface{
	
	protected $tableName = 'anthroponym';
	protected $primaryKey = ['type', 'value'];
	
	public function save(AnthroponymInterface $anthroponym){
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($anthroponym));
		
		$this->checkTypeExist($anthroponym->getType());
		
		$row->save();
		return $anthroponym->populate($row);
	}
	
	protected function extractData(AnthroponymInterface $anthroponym){
		return [
			'type' => $anthroponym->getType(),
			'value' => $anthroponym->getValue(),
		];
	}
	
	protected function checkTypeExist($type){
		$tableGateway = new TableGateway('anthroponym_type', $this->adapter);
		$typeData = ['anthroponym_type' => $type];
		$resultSet = $tableGateway->select($typeData);
		if($resultSet->count()){
			return true;
		}else{
			$tableGateway->insert($typeData);
		}
	}
	
	public function delete(AnthroponymInterface $anthroponym){
		
	}
	
	public function getByType($type){
		$tableGateway = new TableGateway('anthroponym', $this->adapter);
		$resultSet = $tableGateway->select(['type' => $type]);
// 		if($resultSet->count() > 0){
			$array = [];
			foreach ($resultSet as $row){
				$array[] = new Anthroponym($row['type'], $row['value']);
			}
			
// 		}
		return $array;
		
	}
}