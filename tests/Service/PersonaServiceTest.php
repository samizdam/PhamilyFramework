<?php

namespace phamily\framework\Service;

use phamily\tests\UnitTest;

/**
 * @author samizdam
 */
class PersonaServiceTest extends UnitTest
{
    public function testPersonaCreatingWithGender()
    {
        $service = new PersonaService();
        $gender = $service::GENDER_MALE;
        $persona = $service->create($gender);

        $this->assertInstanceOf(\phamily\framework\Model\PersonaInterface::class, $persona);
        $this->assertEquals($gender, $persona->getGender());
    }

    public function testPersonaCreatingWithNames()
    {
        $service = new PersonaService();
        $persona = $service->create(null, [
            'personalName' => 'Vasya',
            'surname' => 'Pupkin',
        ]);

        $this->assertEquals('Vasya', $persona->getName('personalName'));
        $this->assertEquals('Pupkin', $persona->getName('surname'));
    }

    public function testDeletePersona()
    {
        $service = new PersonaService();
        $persona = $service->create();
        $service->delete($persona);
        $this->assertEmpty($persona);
    }
}
