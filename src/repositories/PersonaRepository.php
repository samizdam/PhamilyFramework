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
		/*
		 * save persona
		 */
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($persona));
		$row->save();
		$persona->populate($row);
		
		/*
		 * save names
		 */
		$anthroponymRepo = $this->factory(AnthroponymRepository::class);
		foreach ($persona->getNames() as $name){
			$anthroponymRepo->save($name);
			$relationTableGateway = new TableGateway('persona_has_names', $this->adapter);
			$relationTableGateway->insert(['personaId' => $persona->getId(), 'nameId' => $name->getId()]);
		}
		
		return $persona; 
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