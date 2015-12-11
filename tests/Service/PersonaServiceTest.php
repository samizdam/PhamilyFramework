<?php

namespace Phamily\Framework\Service;

use Phamily\tests\UnitTest;

/**
 * @author samizdam
 */
class PersonaServiceTest extends UnitTest
{
    public function testCreatePersonaeWithGender()
    {
        $service = new PersonaService();
        $gender = $service::GENDER_MALE;
        $persona = $service->createPersona($gender);

        $this->assertInstanceOf(\Phamily\Framework\Model\PersonaInterface::class, $persona);
        $this->assertEquals($gender, $persona->getGender());
    }

    public function testCreatePersonaWithNames()
    {
        $service = new PersonaService();
        $persona = $service->createPersona(null, [
            'personalName' => 'Vasya',
            'surname' => 'Pupkin',
        ]);

        $this->assertEquals('Vasya', $persona->getName('personalName'));
        $this->assertEquals('Pupkin', $persona->getName('surname'));
    }

    public function testDeletePersona()
    {
        $service = new PersonaService();
        $persona = $service->createPersona();
        $service->deletePersona($persona);
        $this->assertEmpty($persona);
    }
}
