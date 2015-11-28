<?php
namespace phamily\framework\validators;

use phamily\framework\models\traits\PersonaStubTrait;
use phamily\tests\UnitTest;

/**
 *
 * @author samizdam
 *        
 */
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