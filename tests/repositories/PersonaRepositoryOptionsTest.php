<?php
namespace phamily\tests\repositories;

use phamily\framework\models\Persona;
use phamily\framework\repositories\PersonaRepository;
use phamily\tests\DbTest;

class PersonaRepositoryOptioinsTest extends DbTest{
	
	private $tableName = 'persona';
	const EXCEPTION_BASE_NS = '\\phamily\\framework\\repositories\\exceptions\\';
	
	private $fixtures;
	protected $repository;
	
	protected function setUp(){
		parent::setUp();
		$this->fixtures = $this->createFullFamilyFixtures();
	} 
	
	public function testGetPersonaWithoutRelations(){		
		$son = $this->getPersonaWithOptions($this->fixtures['son']['id'], PersonaRepository::WITHOUT_RELATED);
		
		$this->assertEmpty($son->getFather());
		$this->assertEmpty($son->getMother());
		$this->assertCount(0, $son->getSpouses());
		$this->assertCount(0, $son->getChildren());
		// TODO test after implemantation
// 		$this->assertCount(0, $son->getSiblings());
	}
	
	public function testGetPersonWithParents(){
		$son = $this->getPersonaWithOptions($this->fixtures['son']['id'], PersonaRepository::WITH_PARENTS);
		
		$this->assertNotEmpty($son->getFather());
		$this->assertNotEmpty($son->getMother());
		$this->assertCount(0, $son->getSpouses());
		$this->assertCount(0, $son->getChildren());
		// TODO test after implemantation
		// 		$this->assertCount(0, $son->getSiblings());		
	}

	public function testGetPersonWithCHildren(){
		$son = $this->getPersonaWithOptions($this->fixtures['son']['id'], PersonaRepository::WITH_CHILDREN);
		
		$this->assertEmpty($son->getFather());
		$this->assertEmpty($son->getMother());
		
		$this->assertCount(3, $son->getChildren());
		$this->assertCount(0, $son->getSpouses());
		// TODO test after implemantation
		// 		$this->assertCount(0, $son->getSiblings());		
	}
	
	public function testGetPersonWithSpouse(){
		$son = $this->getPersonaWithOptions($this->fixtures['son']['id'], PersonaRepository::WITH_SPOUSES);
		
		$this->assertEmpty($son->getFather());
		$this->assertEmpty($son->getMother());
		$this->assertEmpty($son->getChildren());
		$this->assertCount(1, $son->getSpouses());
		// TODO test after implemantation
		// 		$this->assertCount(0, $son->getSiblings());		
	}
	
	public function testGetPersonaWithChildrenAndParents(){
		$options = PersonaRepository::WITH_PARENTS | PersonaRepository::WITH_CHILDREN;
// 		var_dump($options);
// 		var_dump(decbin(PersonaRepository::WITH_CHILDREN));
// 		var_dump(decbin($options));
// 		var_dump(($options & PersonaRepository::WITH_PARENTS));
		
		$son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);
		
		$this->assertNotEmpty($son->getFather());
		$this->assertNotEmpty($son->getMother());
		$this->assertCount(3, $son->getChildren());
		$this->assertCount(0, $son->getSpouses());
		// TODO test after implemantation
		// 		$this->assertCount(0, $son->getSiblings());
		
	}
	
	private function getPersonaWithOptions($id, $options){
		return $this->getRepository()->getById($id, $options);
	}
	 
	
	private function getRepository(){
		$repository = new PersonaRepository($this->getDbAdapter());
		return $repository;
	}
	
	private function createFullFamilyFixtures(){
		$male = Persona::GENDER_MALE;
		$female = Persona::GENDER_FEMALE;
		
		$fatherGrandPa = ['id' => 1, 'gender' => $male];
		$fatherGrandMa = ['id' => 2, 'gender' => $female];
				
		
		$father = ['id' => 3, 'gender' => $male, 'fatherId' => 1, 'motherId' => 2];
		$mother = ['id' => 4, 'gender' => $female];
		
		$son = ['id' => 5, 'gender' => $male, 'fatherId' => 3, 'motherId' => 4];
		$sonWife = ['id' => 6, 'gender' => $female];
		
		$grandsonA = ['id' => 7, 'gender' => $male, 'fatherId' => 5, 'motherId' => 6]; 
		$grandsonB = ['id' => 8, 'gender' => $male, 'fatherId' => 5, 'motherId' => 6]; 
		$grandsonC = ['id' => 9, 'gender' => $male, 'fatherId' => 5, 'motherId' => 6]; 

		
		$fixtures = [
			'fatherGnandPa' => $fatherGrandPa,
			'fatherGnandMa' => $fatherGrandMa,
			
			'father' => $father, 
			'mother' => $mother, 
			
			'son' => $son,
			'sonWife' => $sonWife,
			
			'grandsonA' => $grandsonA,
			'grandsonB' => $grandsonB,
			'grandsonC' => $grandsonC,
		];
		foreach ($fixtures as $row){
			$this->insertRowInTable($row, $this->tableName);
		}
		
		$relationships = [
			['husbandId' => $father['id'], 'wifeId' => $mother['id']],
			['husbandId' => $fatherGrandPa['id'], 'wifeId' => $fatherGrandMa['id']],			
			['husbandId' => $son['id'], 'wifeId' => $sonWife['id']],			
		];
		foreach ($relationships as $spousesRel){
			$this->insertRowInTable($spousesRel, 'spouse_relationship');
		}
		
		return $fixtures;
	}
	

}