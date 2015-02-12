<?php
namespace phamily\tests\repositories;

use phamily\framework\services\PersonaService;
use phamily\tests\UnitTest;

class PersonaServiceTest extends UnitTest{
	
	public function testPersonaCreatingWithGender(){
		$service = new PersonaService();
		$gender = $service::GENDER_MALE;
		$persona = $service->create($gender);
		
		$this->assertInstanceOf(\phamily\framework\models\PersonaInterface::class, $persona);
		$this->assertEquals($gender, $persona->getGender());
	}
	
	public function testPersonaCreatingWithNames(){
		$service = new PersonaService();
		$persona = $service->create(null, ['personalName' => 'Vasya', 'surname' => 'Pupkin']);
		
		$this->assertEquals('Vasya', $persona->getName('personalName'));
		$this->assertEquals('Pupkin', $persona->getName('surname'));
	}
}