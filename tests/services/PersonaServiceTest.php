<?php
use phamily\framework\services\PersonaService;

class PersonaServiceTest extends UnitTest{
	public function testPersonaCreating(){
		$service = new PersonaService();
		$persona = $service->create($service::MALE);
		$this->assertInstanceOf(\phamily\framework\models\PersonaInterface::class, $persona);
	}
}