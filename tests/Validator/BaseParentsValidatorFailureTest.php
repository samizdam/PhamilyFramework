<?php

namespace Phamily\Framework\Validator;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\tests\UnitTest;
use Phamily\Framework\Model\traits\PersonaStubTrait;

/**
 * @author samizdam
 */
class BaseParentsValidatorFailureTest extends UnitTest
{
    use PersonaStubTrait;

    public function testIsValidFatherGenderFail()
    {
        $personaStub = $this->createPersonaStub();

        $fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE);

        $validator = new BaseParentsValidator();
        $this->assertFalse($validator->isValidFather($personaStub, $fatherStub));
    }

    public function testIsValidMotherGenderFail()
    {
        $personaStub = $this->createPersonaStub();

        $motherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE);

        $validator = new BaseParentsValidator();
        $this->assertFalse($validator->isValidMother($personaStub, $motherStub));
    }

    public function testIsValidFatherOldFail()
    {
        $personaStub = $this->createPersonaStub(null, '1986');

        $fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE, '2012');

        $validator = new BaseParentsValidator();
        $this->assertFalse($validator->isValidFather($personaStub, $fatherStub));
    }

    public function testIsValidMotherOldFail()
    {
        $personaStub = $this->createPersonaStub(null, '1980');

        $motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE, '2003');

        $validator = new BaseParentsValidator();
        $this->assertFalse($validator->isValidMother($personaStub, $motherStub));
    }
}
