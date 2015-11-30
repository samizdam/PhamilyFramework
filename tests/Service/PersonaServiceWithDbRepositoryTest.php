<?php

namespace phamily\framework\Service;

use phamily\tests\DbTest;
use phamily\tests\traits\FullFamilyFixtureTrait;
use phamily\tests\Service\traits\CreateServiceTrait;

/**
 * @author samizdam
 */
class PersonaServiceWithDbRepositoryTest extends DbTest
{
    use CreateServiceTrait;
    use FullFamilyFixtureTrait;

    public function testNewPersonaIsPersisted()
    {
        $service = $this->createServiceWithRepository();
        $persona = $service->create();

        $this->assertTableHasData('persona', [
            'id' => $persona->getId(),
            'gender' => $persona->getGender(),
        ]);
    }

    public function testDeletePersona()
    {
        $service = $this->createServiceWithRepository();

        $persona = $service->create();
        $personaId = $persona->getId();

        $this->assertTableHasData('persona', [
            'id' => $personaId,
        ]);

        $service->delete($persona);
        $this->assertTableHasNotData('persona', [
            'id' => $personaId,
        ]);
    }

    public function testGetFullSiblings()
    {
        $service = $this->createServiceWithRepository();
        $fixtures = $this->createFullFamilyFixtures();

        $son = $service->getById($fixtures['son']['id']);
        $siblings = $service->getSiblings($son, $service::FULL_SIBLINGS);
        $this->assertCount(1, $siblings);
        $this->assertEquals($service::GENDER_FEMALE, $siblings[0]->getGender());
    }
}