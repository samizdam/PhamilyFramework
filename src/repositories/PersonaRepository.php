<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;
use phamily\framework\models\Persona;
use phamily\framework\repositories\exceptions\NotFoundException;

class PersonaRepository extends AbstractRepository implements PersonaRepositoryInterface{
	
	protected $tableName = 'persona';
	protected $primaryKey = 'id';
	
	public function save(PersonaInterface $persona){
		/*
		 * TODO extract to method?
		 * save parents before
		 */
		if($persona->hasFather()  && $this->notSaved($persona->getFather())){
			$this->save($persona->getFather());
		}
		if($persona->hasMother() && $this->notSaved($persona->getMother())){
			$this->save($persona->getMother());
		}
		
		
		/*
		 * 
		 * save persona
		 */
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($persona), !$this->notSaved($persona));
		$row->save();
		$persona->populate($row);

		/*
		 * TODO extract to method?
		 * save names
		 */
		$anthroponymRepo = $this->factory(AnthroponymRepository::class);
		foreach ($persona->getNames() as $name){
			$anthroponymRepo->save($name);
			$relationTableGateway = new TableGateway('persona_has_names', $this->adapter);
			$relationTableGateway->insert(['personaId' => $persona->getId(), 'nameId' => $name->getId()]);
		}
		
		/*
		 * TODO extract to method?
		 * save childs after
		 */
		if(count($persona->getChilds())){
			foreach ($persona->getChilds() as $child){
				if($this->notSaved($child)){
					$this->save($child);
				}
			}
		}
		
		return $persona; 
	} 
	
	protected function notSaved(PersonaInterface $persona){
		return $persona->getId() === null;
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
			throw new NotFoundException("Persona with id {$id} not found");
		}
	}
	
	protected function extractData(PersonaInterface $persona){
		$data = [
			'id' => $persona->getId(),
			'gender' => $persona->getGender(),
			'fatherId' => $persona->hasFather() ? $persona->getFather()->getId() : null,
			'motherId' => $persona->hasMother() ? $persona->getMother()->getId() : null,
		];
		return $data;
	}
	
	public function delete(PersonaInterface $persona){
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($persona), true);
		$row->delete();
		unset($persona);
	}
}