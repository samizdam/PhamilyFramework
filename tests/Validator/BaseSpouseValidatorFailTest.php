<?php

namespace Phamily\Framework\Validator;

use Phamily\tests\UnitTest;
use Phamily\Framework\Model\traits\PersonaStubTrait;

/**
 * @author samizdam
 */
class BaseSpouseValidatorFailTest extends UnitTest
{
    use PersonaStubTrait;

    public function testWithGender()
    {
        $validator = new BaseSpouseValidator();
        $persona = $this->createPersonaStub($validator::GENDER_FEMALE);
        $spouse = $this->createPersonaStub($validator::GENDER_FEMALE);

        $this->assertFalse($validator->isValidSpouse($persona, $spouse));
        $this->assertCount(1, $validator->getErrors());
    }

    public function testWithoutGender()
    {
        $validator = new BaseSpouseValidator();
        $persona = $this->createPersonaStub($validator::GENDER_FEMALE);
        $spouse = $this->createPersonaStub();

        $this->assertFalse($validator->isValidSpouse($persona, $spouse));
        $this->assertCount(1, $validator->getErrors());
    }

    public function testGermafrodit()
    {
        $validator = new BaseSpouseValidator();
        $persona = $this->createPersonaStub($validator::GENDER_FEMALE);
        $spouse = $persona;

        $this->assertFalse($validator->isValidSpouse($persona, $spouse));
        $this->assertCount(2, $validator->getErrors());
    }

    public function testWithDates()
    {
        $validator = new BaseSpouseValidator();
        $persona = $this->createPersonaStub($validator::GENDER_FEMALE, 2010, 2050);
        $spouse = $this->createPersonaStub($validator::GENDER_MALE, 1900, 1950);

        $this->assertFalse($validator->isValidSpouse($persona, $spouse));
        $this->assertCount(1, $validator->getErrors());

        $this->assertFalse($validator->isValidSpouse($spouse, $persona));
        $this->assertCount(1, $validator->getErrors());
    }

    public function testReset()
    {
        $validator = new BaseSpouseValidator();
        $persona = $this->createPersonaStub();
        $spouse = $persona;

        $validator->isValidSpouse($persona, $spouse);
        $this->assertGreaterThanOrEqual(1, $validator->getErrors());

        $validator->reset();
        $this->assertCount(0, $validator->getErrors());
    }
}
