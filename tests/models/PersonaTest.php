<?php
use phamily\framework\models\Persona;
class PersonaTest extends UnitTest{
	
	const BASE_EXCEPTION_NS = '\\phamily\\framework\\models\\exceptions\\';
	
	public function testConstructWithGender(){
		$persona = new Persona(Persona::GENDER_MALE);
		$this->assertEquals(Persona::GENDER_MALE, $persona->getGender());
		$this->setExpectedException(self::BASE_EXCEPTION_NS . 'LogicException');
		$persona->setGender(Persona::GENDER_FEMALE);
	}
	
	public function testConstructWithNames(){
		$nameType = 'firstName';
		$nameValue = 'Vasya';
		$persona = new Persona(null, [$nameType => $nameValue]);
		$this->assertEquals($nameValue, $persona->getName($nameType));
	}
	
	public function testFatherFemaleException(){
		$father = new Persona(Persona::GENDER_FEMALE);
		
		$this->setExpectedException(self::BASE_EXCEPTION_NS . 'LogicException', null);
		$son = new Persona(Persona::GENDER_MALE);
		$son->setFather($father);
	}
	
}