<?php
namespace phamily\tests\models\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\validators\BaseParentsValidator;
use phamily\tests\UnitTest;

class BaseParentsValidatorSuccessTest extends UnitTest{
	
	use PersonaStubTrait;
	
	public function testIsValidFatherGenderSuccess(){
		$personaStub = $this->createPersonaStub();
		
		$fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE);
		
		$validator = new BaseParentsValidator();
		$this->assertTrue($validator->isValidFather($personaStub, $fatherStub));
	}
	
	public function testIsValidMotherGenderSuccess(){
		$personaStub = $this->createPersonaStub();
		
		$motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE);
		
		$validator = new BaseParentsValidator();
		$this->assertTrue($validator->isValidMother($personaStub, $motherStub));
	}
	
	public function testIsValidFatherOldSuccess(){
		$personaStub = $this->createPersonaStub();
		$personaStub->method('getDateOfBirth')->willReturn('2012');
		
		$fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE);
		$fatherStub->method('getDateOfBirth')->willReturn('1986');
		
		$validator = new BaseParentsValidator();
		$this->assertTrue($validator->isValidFather($personaStub, $fatherStub));
	}
	
	public function testIsValidMotherOldSuccess(){
		$personaStub = $this->createPersonaStub();
		$personaStub->method('getDateOfBirth')->willReturn('2003');
		
		$motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE);
		$motherStub->method('getDateOfBirth')->willReturn('1980');
		
		$validator = new BaseParentsValidator();
		$this->assertTrue($validator->isValidMother($personaStub, $motherStub));		
	}
	
	protected function createPersonaStub($gender = null){
		$personaStub = $this->getMockBuilder(PersonaInterface::class)->getMock();
		if(isset($gender)){
			$personaStub->method('getGender')->willReturn($gender);
		}
		return $personaStub;
	}
}