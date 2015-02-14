<?php
namespace phamily\tests\models\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\validators\BaseParentsValidator;
use phamily\tests\UnitTest;
use phamily\tests\models\traits\PersonaStubTrait;

class BaseParentsValidatorFailureTest extends UnitTest{
	
	use PersonaStubTrait;
	
	public function testIsValidFatherGenderFail(){
		$personaStub = $this->createPersonaStub();
		
		$fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE);
		
		$validator = new BaseParentsValidator();
		$this->assertFalse($validator->isValidFather($personaStub, $fatherStub));
	}
	
	public function testIsValidMotherGenderFail(){
		$personaStub = $this->createPersonaStub();
		
		$motherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE);
		
		$validator = new BaseParentsValidator();
		$this->assertFalse($validator->isValidMother($personaStub, $motherStub));
	}
	
	public function testIsValidFatherOldFail(){
		$personaStub = $this->createPersonaStub(null, '1986');
		
		$fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE, '2012');
		
		$validator = new BaseParentsValidator();
		$this->assertFalse($validator->isValidFather($personaStub, $fatherStub));
	}
	
	public function testIsValidMotherOldFail(){
		$personaStub = $this->createPersonaStub(null, '1980');
		
		$motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE, '2003');
		
		$validator = new BaseParentsValidator();
		$this->assertFalse($validator->isValidMother($personaStub, $motherStub));		
	}

}