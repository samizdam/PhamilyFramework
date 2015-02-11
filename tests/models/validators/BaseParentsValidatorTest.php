<?php
use phamily\framework\models\PersonaInterface;
use phamily\framework\models\validators\BaseParentsValidator;
class BaseParentsValidatorTest extends UnitTest{
	public function testIsValidFatherSuccess(){
		$personaStub = $this->getMockBuilder(PersonaInterface::class)->getMock();
		
		$fatherStub = $this->getMockBuilder(PersonaInterface::class)->getMock();
		$fatherStub->method('getGender')->willReturn(PersonaInterface::GENDER_MALE);
		
		$validator = new BaseParentsValidator();
		$this->assertTrue($validator->isValidFather($personaStub, $fatherStub));
	}
	
	public function testIsValidMotherSuccess(){
		$personaStub = $this->getMockBuilder(PersonaInterface::class)->getMock();
		
		$motherStub = $this->getMockBuilder(PersonaInterface::class)->getMock();
		$motherStub->method('getGender')->willReturn(PersonaInterface::GENDER_FEMALE);
		
		$validator = new BaseParentsValidator();
		$this->assertTrue($validator->isValidMother($personaStub, $motherStub));
	}
}