<?php
namespace phamily\tests\repositories;

use phamily\framework\services\PersonaService;
use phamily\tests\UnitTest;
use phamily\tests\DbTest;
use phamily\framework\repositories\PersonaRepository;

class PersonaServiceWithDbRepositoryTest extends DbTest{
	
	public function testDeletePersona(){
		$repository = new PersonaRepository($this->getDbAdapter());
		$service = new PersonaService();
		$service->useRepository($repository);
		
		$persona = $service->create();
		$personaId = $persona->getId();
		
		$this->assertTableHasData('persona', ['id' => $personaId]);
		
		$service->delete($persona);
		$this->assertTableHasNotData('persona', ['id' => $personaId]);
	}
}