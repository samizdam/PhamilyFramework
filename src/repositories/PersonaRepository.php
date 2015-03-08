<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\TableGateway\TableGateway;
use phamily\framework\models\Persona;
use phamily\framework\repositories\exceptions\NotFoundException;
use phamily\framework\traits\BitmaskTrait; 
use Zend\Db\Sql\Where;
use phamily\framework\repositories\conditions\SiblingsQueryCondition;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class PersonaRepository extends AbstractRepository 
		implements PersonaRepositoryInterface{
	
	use BitmaskTrait;
	
	protected $tableName = 'persona';
	protected $primaryKey = 'id';
	
	/**
	 * 
	 * @var PersonaRepositoryCacheInterface
	 */
	protected $cache;
	
	public function __construct($adapter){
		parent::__construct($adapter);
		$this->cache = new BasePersonaRepositoryCache();
	}
	
	public function save(PersonaInterface $persona){
		/*
		 * TODO extract to method?
		 * save parents before
		 */
		if($persona->hasFather() && $this->notSaved($persona->getFather())){
			$this->save($persona->getFather());
		}
		if($persona->hasMother() && $this->notSaved($persona->getMother())){
			$this->save($persona->getMother());
		}
		
		
		/*
		 * 
		 * save persona
		 */
		$rowData = $this->extractData($persona);
		
		if($this->notSaved($persona)){
			$ai = new SequenceFeature($this->primaryKey, 'persona_id_increment');
			$tgw = $this->createTableGateway($this->tableName, $ai);
			
			$rowData['createdAt'] = date('Y-m-d H:i:s');
			$tgw->insert($rowData);
			$rowData = $tgw->select(['id' => $tgw->getLastInsertValue()])->current();
		}else{
			$row = $this->getRowGatewayInstance();
			$row->populate($rowData, true);
			$row->save();
			$rowData = $row->toArray();
		}
		
		$persona->populate($rowData);
// 		$row->populate($this->extractData($persona), !$this->notSaved($persona));
		
		

		/*
		 * TODO extract to method?
		 * save names
		 */
		$anthroponymRepo = $this->factory(AnthroponymRepository::class);
		foreach ($persona->getNames() as $name){
			$anthroponymRepo->save($name);
			$relationTableGateway = new TableGateway('persona_has_names', $this->adapter);
			$relationRowData = ['personaId' => $persona->getId(), 'nameId' => $name->getId()];
			$relationTableGateway->insert($relationRowData);
		}
		
		/*
		 * save spouse relation
		 */
		$spouseRelationTableGateway = $this->createTableGateway('spouse_relationship');
		foreach ($persona->getSpouses() as $spouse){
			if($this->notSaved($spouse)){
				$this->save($spouse);
			}
			list($husband, $wife) = $this->normalizeSpousePair($persona, $spouse);
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
	protected function normalizeSpousePair(PersonaInterface $persona, PersonaInterface $spouse){
		return ($persona->getGender() === PersonaInterface::GENDER_MALE) 
			? [$persona, $spouse] 
			: [$spouse, $persona];
	}
	
	protected function notSaved(PersonaInterface $persona){
		return $persona->getId() === null;
	} 
	
	/**
	 * @throws
	 * @return Persona
	 */
	public function getById($id, $fetchWithOptions = self::WITHOUT_KINSHIP){
		$options = $fetchWithOptions;
		
		if($this->cache->has($id)){
			$persona = $this->cache->getObject($id);
			$data = $this->cache->getData($id);
			if($this->cache->getOptions($id) === $options){
				return $persona;
			}			
		} else {
			$tableGateway = new TableGateway($this->tableName, $this->adapter);
			$resultSet = $tableGateway->select(['id' => $id]);

			if($resultSet->count()){
				$data = $resultSet->current();
				$persona = (new Persona())->populate($data);
					
				if(!$this->cache->has($id)){
					$this->cache->add($persona, $data, $options);
				}
			}					
		}	

		if(empty($persona)){
			throw new NotFoundException("Persona with id {$id} not found");
		}
		
		if($this->isFlagSet($options, self::SPOUSES)){
			$this->fetchSpouses($persona, $data, $options);
		}
		
		if($this->isFlagSet($options, self::PARENTS)){
			$this->fetchParents($persona, $data, $options);
		}

		if($this->isFlagSet($options, self::CHILDREN) 
				&& $persona->getGender() !== $persona::GENDER_UNDEFINED){
			$this->fetchChildren($persona, $data, $options);
		}

		return $persona; 
	}
	
	public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS){
		
		$siblings = [];
		
		$personaData = $this->cache->getData($persona->getId());
		
		$siblingCondition = new SiblingsQueryCondition($personaData);
		$where = $siblingCondition->getPredicate($degreeOfKinship);
		
		$siblingRows = $this->createTableGateway($this->tableName)->select($where);
		
		foreach ($siblingRows as $row){
				$siblings[] = $this->getById($row['id'], $degreeOfKinship);
		}
		
		return $siblings;
	}
	
	protected function fetchChildren(PersonaInterface $persona, $data, $options){
		$parentColumnName = ($persona->getGender() === $persona::GENDER_MALE)
			? 'fatherId'
			: 'motherId';
		
		$childrenRows = $this->createTableGateway($this->tableName)->select([$parentColumnName => $persona->getId()]);
		foreach ($childrenRows as $childRow){
			$child = $this->getById($childRow['id'], $options);
			if(!$persona->getChildren()->contains($child))	$persona->addChild($child);
		}
		
	}
	
	protected function fetchSpouses(PersonaInterface $persona, $data, $options){
		$spouseRelationshipTableGateway = $this->createTableGateway('spouse_relationship');
		$spouseRelationsSet = [];
		if($persona->getGender() === $persona::GENDER_MALE){
			$spouseRelationsSet = $spouseRelationshipTableGateway->select(['husbandId' => $persona->getId()]);
			foreach ($spouseRelationsSet as $spouseRelation){
				$wifeId = $spouseRelation['wifeId'];
				$wife = $this->getById($wifeId, $options);
				if(!$persona->getSpouses()->contains($wife)) $persona->addSpouse($wife);
			}
		} elseif($persona->getGender() === $persona::GENDER_FEMALE){
			$spouseRelationsSet = $spouseRelationshipTableGateway->select(['wifeId' => $persona->getId()]);
			foreach ($spouseRelationsSet as $spouseRelation){
				$husbandId = $spouseRelation['husbandId'];
				$husband = $this->getById($husbandId, $options);
				if(!$persona->getSpouses()->contains($husband)) $persona->addSpouse($husband);
			}
				
		}
	}
	
	protected function fetchParents(PersonaInterface $persona, $data, $options){
		if($fatherId = $data['fatherId']){
			$father = $this->getById($fatherId, $options);
			$persona->setFather($father);
		}
		if($motherId = $data['motherId']){
			$mother = $this->getById($motherId, $options);
			$persona->setMother($mother);
		}
		
	}
	
	protected function extractData(PersonaInterface $persona){
		$data = [
			'gender' => $persona->getGender(),
			'fatherId' => $persona->hasFather() ? $persona->getFather()->getId() : null,
			'motherId' => $persona->hasMother() ? $persona->getMother()->getId() : null,
		];
		if(!$this->notSaved($persona)){
			$data['id'] = $persona->getId(); 
		}
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