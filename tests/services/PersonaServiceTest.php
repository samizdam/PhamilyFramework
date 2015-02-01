<?php
use phamily\framework\services\PersonaService;

class PersonaServiceTest extends UnitTest{
	public function testPersonaCreating(){
		$service = new PersonaService();
		$persona = $service->create($service::GENDER_MALE);
		$this->assertInstanceOf(\phamily\framework\models\PersonaInterface::class, $persona);
	}
}