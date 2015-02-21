<?php
namespace phamily\tests\services;

use phamily\framework\services\PersonaService;
use phamily\tests\DbTest;
use phamily\framework\repositories\PersonaRepository;
use phamily\tests\services\traits\CreateServiceTrait;
use phamily\tests\traits\FullFamilyFixtureTrait;

class PersonaServiceWithDbRepositoryTest extends DbTest{
	
	use CreateServiceTrait; 
	use FullFamilyFixtureTrait;
	
	public function testNewPersonaIsPersisted(){
		$service = $this->createServiceWithRepository();
		$persona = $service->create();
		
		$this->assertTableHasData('persona', ['id' => $persona->getId(), 'gender' => $persona->getGender()]);
	}
	
	public function testDeletePersona(){
		$service = $this->createServiceWithRepository();
		
		$persona = $service->create();
		$personaId = $persona->getId();
		
		$this->assertTableHasData('persona', ['id' => $personaId]);
		
		$service->delete($persona);
		$this->assertTableHasNotData('persona', ['id' => $personaId]);
	}
	
	public function testGetFullSiblings(){
		$service = $this->createServiceWithRepository();
		$fixtures = $this->createFullFamilyFixtures();
		
		$son = $service->getById($fixtures['son']['id']);
		$service->getSiblings($son, $service::FULL_SIBLINGS);
	}
}