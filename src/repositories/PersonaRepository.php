<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;
use phamily\framework\models\Persona;

class PersonaRepository extends AbstractRepository implements PersonaRepositoryInterface{
	
	protected $tableName = 'persona';
	protected $primaryKey = 'id';
	
	public function save(PersonaInterface &$persona){
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($persona));
		$row->save();
		return $persona->populate($row);
	} 
	
	/**
	 * @throws
	 * @return Persona
	 */
	public function getById($id){
		$tableGateway = new TableGateway($this->tableName, $this->adapter);
		$resultSet = $tableGateway->select(['id' => $id]);
		if($resultSet->count()){
			$data = $resultSet->current();
			return (new Persona())->populate($data);
		}else{	
			throw new \Exception("Persona with id {$id} not found");
		}
	}
	
	protected function extractData(PersonaInterface $persona){
		$data = [
			'id' => $persona->getId(),
			'gender' => $persona->getGender(),
			'fatherId' => empty($persona->getFather()) ? null : $persona->getFather()->getId(),
		];
		return $data;
	}
	
	public function delete(PersonaInterface &$persona){
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($persona), true);
		$row->delete();
	}
}