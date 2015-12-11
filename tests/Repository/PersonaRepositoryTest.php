<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\Persona;
use Phamily\tests\DbTest;
use Phamily\tests\Repository\traits\PersonaRepositoryTrait;
use Phamily\Framework\Repository\Exception\NotFoundException;

/**
 * @author samizdam
 */
class PersonaRepositoryTest extends DbTest
{
    use PersonaRepositoryTrait;

    private $tableName = 'persona';

    public function testSaveNewPersona()
    {
        $repository = $this->getRepository();
        $persona = new Persona();
        $this->assertEmpty($persona->getId());
        $savedPersona = $repository->save($persona);
        $this->assertEquals($persona, $savedPersona);
        $this->assertNotEmpty($persona->getId());
    }

    public function testGetPersonaById()
    {
        $repository = $this->getRepository();
        $fixtures = $this->createFamilyFixtures();
        $son = $fixtures['son'];
        $sonPersona = $repository->getPersonaById($son['id']);
        $this->assertEquals($son['id'], $sonPersona->getId());
        $this->assertEquals($son['gender'], $sonPersona->getGender());
    }

    public function testDeleteExistingPersona()
    {
        $son = $this->createFamilyFixtures()['son'];

        $this->assertTableHasData($this->tableName, $son);

        $persona = new Persona();
        $persona->populate($son);

        $repository = $this->getRepository();
        $repository->delete($persona);

        $this->assertTableHasNotData($this->tableName, $son);
    }

    public function testUnlinkChildsWithDeletedPersona()
    {
        $repository = $this->getRepository();
        $fixtures = $this->createFamilyFixtures();

        $father = new Persona();
        $father->populate($fixtures['father']);

        $fatherId = $father->getId();

        $this->assertTableHasData('persona', [
            'father_id' => $father->getId(),
        ]);

        $repository->delete($father);

        $this->assertTableHasNotData('persona', [
            'father_id' => $fatherId,
        ]);
    }

    /**
     * TODO test that names will be saved correct with person.
     */
    public function testSavePersonaWithNames()
    {
        $namesArray = [
            'personalName' => 'Petr',
            'surname' => 'Romanov',
        ];
        $persona = new Persona(Persona::GENDER_MALE, $namesArray);

        $repository = $this->getRepository();
        $repository->save($persona);

        $this->assertTableHasData('anthroponym', [
            'value' => 'Petr',
            'type' => 'personalName',
        ]);
        $this->assertTableHasData('persona_has_name', [
            'persona_id' => $persona->getId(),
        ]);
        // 'nameId' => $persona->getName('surname')->getId()
    }

    public function testSavePersonaWithParents()
    {
        $persona = new Persona();

        $father = new Persona(Persona::GENDER_MALE);
        $mother = new Persona(Persona::GENDER_FEMALE);

        $persona->setFather($father);
        $persona->setMother($mother);

        $repository = $this->getRepository();
        $repository->save($persona);

        $this->assertTableHasData('persona', [
            'id' => $persona->getId(),
            'father_id' => $father->getId(),
            'mother_id' => $mother->getId(),
        ]);
        $this->assertTableHasData('persona', [
            'id' => $father->getId(),
        ]);
        $this->assertTableHasData('persona', [
            'id' => $mother->getId(),
        ]);
    }

    public function testSaveChildsWithPersona()
    {
        $father = new Persona(Persona::GENDER_MALE);
        $son = new Persona(Persona::GENDER_MALE);
        $daughter = new Persona(Persona::GENDER_FEMALE);

        $father->addChild($son);
        $father->addChild($daughter);

        $repository = $this->getRepository();
        $repository->save($father);

        $this->assertTableHasData('persona', [
            'id' => $son->getId(),
            'father_id' => $father->getId(),
        ]);
    }

    public function testPesonaNotFoundException()
    {
        $repository = $this->getRepository();
        $this->setExpectedException(NotFoundException::class);
        $repository->getPersonaById(100500);
    }

    public function testSaveSpousesRelationship()
    {
        $repository = $this->getRepository();
        $husband = new Persona(Persona::GENDER_MALE);
        $wife = new Persona(Persona::GENDER_FEMALE);

        $husband->addSpouse($wife);
        $repository->save($husband);

        $this->assertTableHasData('spouse_relationship', [
            'husband_id' => $husband->getId(),
            'wife_id' => $wife->getId(),
        ]);
    }

    private function createFamilyFixtures()
    {
        $father = [
            'id' => 1,
            'gender' => Persona::GENDER_MALE,
        ];
        $mother = [
            'id' => 2,
            'gender' => Persona::GENDER_FEMALE,
        ];
        $son = [
            'id' => 3,
            'gender' => Persona::GENDER_MALE,
            'father_id' => 1,
            'mother_id' => 2,
        ];
        $fixtures = [
            'father' => $father,
            'mother' => $mother,
            'son' => $son,
        ];
        foreach ($fixtures as $row) {
            $this->insertRowInTable($row, $this->tableName);
        }

        $relationship = [
            'husband_id' => $father['id'],
            'wife_id' => $mother['id'],
        ];
        $this->insertRowInTable($relationship, 'spouse_relationship');

        return $fixtures;
    }
}
