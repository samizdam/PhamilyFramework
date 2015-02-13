<?php
namespace phamily\tests\repositories;

use phamily\framework\models\Persona;
use phamily\framework\repositories\PersonaRepository;
use phamily\tests\DbTest;

class PersonaRepositoryTest extends DbTest{
	
	private $tableName = 'persona';
	const EXCEPTION_BASE_NS = '\\phamily\\framework\\repositories\\exceptions\\';
	private function getRepository(){
		$repository = new PersonaRepository($this->getDbAdapter());
		return $repository;
	}
	
	public function testSaveNewPersona(){
		$repository = $this->getRepository();
		$persona = new Persona();
		$this->assertEmpty($persona->getId());
		$savedPersona = $repository->save($persona);
		$this->assertEquals($persona, $savedPersona);
		$this->assertNotEmpty($persona->getId());
	}
	
	public function testGetPersonaById(){
		$repository = $this->getRepository();
		$fixtures = $this->getFamilyFixtures();
		$son = $fixtures['son'];
		$sonPersona = $repository->getById($son['id']);
		$this->assertEquals($son['id'], $sonPersona->getId());
		$this->assertEquals($son['gender'], $sonPersona->getGender());
	}
	
	public function testDeleteExistingPersona(){
		$son = $this->getFamilyFixtures()['son'];
		
		$this->assertTableHasData($this->tableName, $son);
		
		$persona = new Persona();
		$persona->populate($son);
		
		$repository = $this->getRepository();
		$repository->delete($persona);
		
		$this->assertTableHasNotData($this->tableName, $son);
	}
	
	/**
	 * TODO test that names will be saved correct with person
	 */
	public function testSavePersonaWithNames(){
		$namesArray = ['personalName' => 'Petr', 'surname' => 'Romanov'];
		$persona = new Persona(Persona::GENDER_MALE, $namesArray);
		
		$repository = $this->getRepository();
		$repository->save($persona);
		
		$this->assertTableHasData('anthroponym', ['value' => 'Petr', 'type' => 'personalName']);
		$this->assertTableHasData('persona_has_names', [
					'personaId' => $persona->getId(), 
// 					'nameId' => $persona->getName('surname')->getId()
		]);
	}
	
	public function testSavePersonaWithParents(){
		$persona = new Persona();
		
		$father = new Persona(Persona::GENDER_MALE);
		$mother = new Persona(Persona::GENDER_FEMALE);
		
		$persona->setFather($father);
		$persona->setMother($mother);
		
		$repository = $this->getRepository();
		$repository->save($persona);
		
		$this->assertTableHasData('persona', ['id' => $persona->getId(), 'fatherId' => $father->getId(), 'motherId' => $mother->getId()]);
		$this->assertTableHasData('persona', ['id' => $father->getId()]);
		$this->assertTableHasData('persona', ['id' => $mother->getId()]);
	}
	
	public function testSaveChildsWithPersona(){
		$father = new Persona(Persona::GENDER_MALE);
		$son = new Persona(Persona::GENDER_MALE);
		$daughter = new Persona(Persona::GENDER_FEMALE);
		
		$father->addChild($son);
		$father->addChild($daughter);
		
		$repository = $this->getRepository();
		$repository->save($father);
		
		$this->assertTableHasData('persona', ['id' => $son->getId(), 'fatherId' => $father->getId()]);
	}
	
	public function testPesonaNotFoundException(){
		$repository = $this->getRepository();
		$this->setExpectedException(self::EXCEPTION_BASE_NS . 'NotFoundException');
		$repository->getById(100500);
	}
	
	private function getFamilyFixtures(){
		$father = ['id' => 1, 'gender' => Persona::GENDER_MALE];
		$mother = ['id' => 2, 'gender' => Persona::GENDER_MALE];
		$son = ['id' => 3, 'gender' => Persona::GENDER_MALE, 'fatherId' => 1, 'motherId' => 2];
		$fixtures = [
			'father' => $father, 
			'mother' => $mother, 
			'son' => $son
		];
		foreach ($fixtures as $row){
			$this->insertRowInTable($row, $this->tableName);
		}
		return $fixtures;
	}
}