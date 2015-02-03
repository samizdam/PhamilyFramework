<?php
use phamily\framework\models\Anthroponym;
use phamily\framework\repositories\AnthroponymRepository;

class AnthroponymRepositoryTest extends DbTest{
	
	private $tableName = 'anthroponym';
	
	public function testSaveNewAnthroponym(){
		$type = 'firstName';
		$value = 'Vasya';
		$data = ['type' => $type, 'value' => $value];
		
		$this->assertTableHasNotData($this->tableName, $data);
		
		$anthroponym = new Anthroponym($type, $value);
		$repository = $this->getRepository();
		
		$repository->save($anthroponym);
		
		$this->assertTableHasData($this->tableName, $data);		
	}
	
	public function testGetExistingAnthroponym(){
		$fixtures = $this->prepareFixtures();
		$fixture = $fixtures[0];
		$repository = $this->getRepository();
		$antroponyms = $repository->getByType($fixture['type']);
		$this->assertEquals($fixture['value'], $antroponyms[0]->getValue());
	}
	
	public function testDeleteAnthroponym(){
		$this->prepareFixtures();
	}
	
	private function prepareFixtures(){
		$fixtures = [ 
			['type' => 'firstName', 'value' => 'Vasia']
		];
		foreach ($fixtures as $rowData){
			$this->insertRowInTable(['anthroponym_type' => $rowData['type']], 'anthroponym_type');
			$this->insertRowInTable($rowData, $this->tableName);
		}
		
		return $fixtures;
	}
	
	private function getRepository(){
		return new AnthroponymRepository($this->getDbAdapter());
	}
	
}