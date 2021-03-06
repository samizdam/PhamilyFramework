<?php

namespace Phamily\Framework\Validator;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\tests\UnitTest;
use Phamily\Framework\Model\traits\PersonaStubTrait;

/**
 * @author samizdam
 */
class BaseParentsValidatorSuccessTest extends UnitTest
{
    use PersonaStubTrait;

    public function testIsValidFatherGenderSuccess()
    {
        $personaStub = $this->createPersonaStub();

        $fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE);

        $validator = new BaseParentsValidator();
        $this->assertTrue($validator->isValidFather($personaStub, $fatherStub));
    }

    public function testIsValidMotherGenderSuccess()
    {
        $personaStub = $this->createPersonaStub();

        $motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE);

        $validator = new BaseParentsValidator();
        $this->assertTrue($validator->isValidMother($personaStub, $motherStub));
    }

    public function testIsValidFatherOldSuccess()
    {
        $personaStub = $this->createPersonaStub(null, '2012');

        $fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE, '1986');

        $validator = new BaseParentsValidator();
        $this->assertTrue($validator->isValidFather($personaStub, $fatherStub));
    }

    public function testIsValidMotherOldSuccess()
    {
        $personaStub = $this->createPersonaStub(null, '2003');

        $motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE, '1980');

        $validator = new BaseParentsValidator();
        $this->assertTrue($validator->isValidMother($personaStub, $motherStub));
    }

    public function testIsValidParentsWithoutOld()
    {
        $personaStub = $this->createPersonaStub(null, '2003');

        $motherStub = $this->createPersonaStub(PersonaInterface::GENDER_FEMALE);
        $fatherStub = $this->createPersonaStub(PersonaInterface::GENDER_MALE);

        $validator = new BaseParentsValidator();
        $this->assertTrue($validator->isValidFather($personaStub, $fatherStub));
        $this->assertTrue($validator->isValidMother($personaStub, $motherStub));
    }
}
