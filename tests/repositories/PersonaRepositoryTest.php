<?php

use phamily\framework\models\Persona;
use phamily\framework\repositories\PersonaRepository;

class PersonaRepositoryTest extends DbTest{
	public function testSaveNewPersona(){
		$repository = new PersonaRepository($this->getDbAdapter());
		$persona = new Persona();
		$this->assertEmpty($persona->getId());
		$savedPersona = $repository->save($persona);
		$this->assertEquals($persona, $savedPersona);
		$this->assertNotEmpty($persona->getId());
	}
}