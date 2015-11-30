<?php

namespace Phamily\Framework\Repository;

use Phamily\tests\DbTest;
use Phamily\tests\traits\FullFamilyFixtureTrait;
use Phamily\tests\Repository\traits\PersonaRepositoryTrait;

/**
 * @author samizdam
 */
class PersonaRepositoryGetSiblingsTest extends DbTest
{
    use FullFamilyFixtureTrait;
    use PersonaRepositoryTrait;

    public function testGetHalfSiblings()
    {
        $repository = $this->getRepository();
        $fixtures = $this->createFullFamilyFixtures();

        $son = $repository->getById($fixtures['son']['id']);
        $siblings = $repository->getSiblings($son, $repository::HALF_SIBLING);

        $this->assertCount(2, $siblings);
    }

    public function testGetHalfBrother()
    {
        $repository = $this->getRepository();
        $fixtures = $this->createFullFamilyFixtures();

        $son = $repository->getById($fixtures['son']['id']);
        $siblings = $repository->getSiblings($son, $repository::HALF_BROTHER);

        $this->assertCount(1, $siblings);
    }

    public function testGetHalfSister()
    {
        $repository = $this->getRepository();
        $fixtures = $this->createFullFamilyFixtures();

        $son = $repository->getById($fixtures['son']['id']);
        $siblings = $repository->getSiblings($son, $repository::HALF_SISTER);

        $this->assertCount(1, $siblings);
    }

    public function testGetHalfSisterPaternal()
    {
        $repository = $this->getRepository();
        $fixtures = $this->createFullFamilyFixtures();

        $son = $repository->getById($fixtures['son']['id']);
        $siblings = $repository->getSiblings($son, $repository::HALF_SISTER_PATERNAL);

        $this->assertCount(0, $siblings);
    }
}
