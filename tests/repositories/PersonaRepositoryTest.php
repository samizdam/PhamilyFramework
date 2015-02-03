<?php

use phamily\framework\models\Persona;
use phamily\framework\repositories\PersonaRepository;

class PersonaRepositoryTest extends DbTest{
	
	private $tableName = 'persona';
	
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