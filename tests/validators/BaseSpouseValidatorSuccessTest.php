<?php
namespace phamily\tests\validators;

use phamily\tests\models\traits\PersonaStubTrait;
use phamily\tests\UnitTest;
use phamily\framework\validators\BaseSpouseValidator;

class BaseSpouseValidatorSuccessTest extends UnitTest
{
    
    use PersonaStubTrait;

    public function testIsValidSpouse()
    {
        $validator = new BaseSpouseValidator();
        $persona = $this->createPersonaStub($validator::GENDER_MALE);
        $spouse = $this->createPersonaStub($validator::GENDER_FEMALE);
        
        $this->assertTrue($validator->isValidSpouse($persona, $spouse));
        $this->assertCount(0, $validator->getErrors());
    }
}