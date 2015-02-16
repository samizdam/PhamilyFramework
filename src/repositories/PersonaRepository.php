<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;
use phamily\framework\models\Persona;
use phamily\framework\repositories\exceptions\NotFoundException;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Predicate;

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
		 * save spouse relation
		 */
		$spouseRelationTableGateway = $this->createTableGateway('spouse_relationship');
		foreach ($persona->getSpouses() as $spouse){
			list($husband, $wife) = $this->getSpousePair($persona, $spouse);
			$data = ['husbandId' => $husband->getId(), 'wifeId' => $wife->getId()];
			$spouseRelationTableGateway->insert($data);
		}
		
		/*
		 * TODO extract to method?
		 * save childs after
		 */
		if(count($persona->getChildren())){
			foreach ($persona->getChildren() as $child){
				if($this->notSaved($child)){
					$this->save($child);
				}
			}
		}
		
		return $persona; 
	} 
	
	/**
	 * 
	 * @param PersonaInterface $persona
	 * @param PersonaInterface $spouse
	 * @return array($husband, $wife)
	 */
	protected function getSpousePair(PersonaInterface $persona, PersonaInterface $spouse){
		return ($persona->getGender() === PersonaInterface::GENDER_MALE) ? [$persona, $spouse] : [$spouse, $persona];
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
			$persona = (new Persona())->populate($data);
			
			$spouseRelationshipTableGateway = $this->createTableGateway('spouse_relationship');
			$spouseRelationsSet = [];
			if($persona->getGender() === $persona::GENDER_MALE){
				$spouseRelationsSet = $spouseRelationshipTableGateway->select(['husbandId' => $persona->getId()]);
				foreach ($spouseRelationsSet as $spouseRelation){
					$wifeId = $spouseRelation['wifeId'];
					$wife = (new Persona())->populate($tableGateway->select(['id' => $wifeId])->current());
					$persona->addSpouse($wife);
				}
			} elseif($persona->getGender() === $persona::GENDER_FEMALE){
				$spouseRelationsSet = $spouseRelationshipTableGateway->select(['wifeId' => $persona->getId()]);
				foreach ($spouseRelationsSet as $spouseRelation){
					$husbandId = $spouseRelation['husbandId'];
					$husband = (new Persona())->populate($tableGateway->select(['id' => $husbandId])->current());
					$persona->addSpouse($husband);
				}
				
			}
			

			return $persona; 
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
		/*
		 * inlink with spouse
		 */
		$spouseTableGateway = $this->createTableGateway('spouse_relationship');
		
		$spouseTableGateway->delete(['husbandId' => $persona->getId()]);
		$spouseTableGateway->delete(['wifeId' => $persona->getId()]);
		
		/*
		 * unlink parent for existing childs
		 */
		$table = $this->createTableGateway($this->tableName);
		$table->update(['fatherId' => null], ['fatherId' => $persona->getId()]);
		$table->update(['motherId' => null], ['motherId' => $persona->getId()]);
		
		/*
		 * delete persona row
		 */
		$row = $this->getRowGatewayInstance();
		$row->populate($this->extractData($persona), true);
		$row->delete();
	}
}