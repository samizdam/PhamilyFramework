<?php

namespace Phamily\Framework\Repository;

use Phamily\tests\traits\FullFamilyFixtureTrait;
use Phamily\tests\DbTest;
use Phamily\tests\Repository\traits\PersonaRepositoryTrait;

/**
 * @author samizdam
 */
class PersonaRepositoryOptionsTest extends DbTest
{
    use FullFamilyFixtureTrait;
    use PersonaRepositoryTrait;

    private $fixtures;

    private $tableName = 'persona';

    protected $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->fixtures = $this->createFullFamilyFixtures();
    }

    public function testGetPersonaWithoutRelations()
    {
        $options = PersonaRepository::WITHOUT_KINSHIP;
        $son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);

        $this->assertEmpty($son->getFather());
        $this->assertEmpty($son->getMother());
        $this->assertCount(0, $son->getSpouses());
        $this->assertCount(0, $son->getChildren());
    }

    public function testGetPersonWithParents()
    {
        $options = PersonaRepository::PARENTS;
        $son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);

        $this->assertNotEmpty($son->getFather());
        $this->assertNotEmpty($son->getMother());
        $this->assertCount(0, $son->getSpouses());
        $this->assertCount(0, $son->getChildren());
    }

    public function testGetPersonWithChildren()
    {
        $options = PersonaRepository::CHILDREN;
        $son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);

        $this->assertEmpty($son->getFather());
        $this->assertEmpty($son->getMother());

        $this->assertCount(3, $son->getChildren());
        $this->assertCount(0, $son->getSpouses());
    }

    public function testGetPersonWithSpouse()
    {
        $options = PersonaRepository::SPOUSES;
        $son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);

        $this->assertEmpty($son->getFather());
        $this->assertEmpty($son->getMother());
        $this->assertEmpty($son->getChildren());
        $this->assertCount(1, $son->getSpouses());
    }

    public function testGetPersonaWithChildrenAndParents()
    {
        $options = PersonaRepository::PARENTS | PersonaRepository::CHILDREN;

        $son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);

        $this->assertNotEmpty($son->getFather());
        $this->assertNotEmpty($son->getMother());
        $this->assertCount(3, $son->getChildren());
        $this->assertCount(0, $son->getSpouses());
    }

    public function testGetPersonaWithAllRelated()
    {
        $options = PersonaRepository::ALL_KINSHIP;

        $son = $this->getPersonaWithOptions($this->fixtures['son']['id'], $options);

        $this->assertNotEmpty($son->getFather());
        $this->assertNotEmpty($son->getMother());
        $this->assertCount(3, $son->getChildren());
        $this->assertCount(1, $son->getSpouses());
    }

    private function getPersonaWithOptions($id, $options)
    {
        return $this->getRepository()->getPersonaById($id, $options);
    }
}
