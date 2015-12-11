<?php

namespace Phamily\Framework\Collection;

use Phamily\tests\UnitTest;
use Phamily\Framework\Model\traits\PersonaStubTrait;
use Phamily\Framework\Model\Exception\LogicException;
use Phamily\Framework\Validator\FakeTrueValidator;

/**
 * @author samizdam
 */
class SpouseCollectionTest extends UnitTest
{
    use PersonaStubTrait;

    public function testAddToCollection()
    {
        $husband = $this->createPersonaStub(SpouseCollection::GENDER_MALE);
        $wife = $this->createPersonaStub(SpouseCollection::GENDER_FEMALE);

        $collection = new SpouseCollection($husband);
        $collection->add($wife);

        $this->assertContains($wife, $collection);
    }

    public function testAddInvalidException()
    {
        $husband = $this->createPersonaStub(SpouseCollection::GENDER_MALE);
        $wawwife = $this->createPersonaStub(SpouseCollection::GENDER_MALE);

        $collection = new SpouseCollection($husband);
        $this->setExpectedException(LogicException::class);
        $collection->add($wawwife);
    }

    public function testWithFakeFalseValidator()
    {
        $persona = $this->createPersonaStub(SpouseCollection::GENDER_MALE);

        $collection = new SpouseCollection($persona);
        $collection->setValidator(new FakeTrueValidator());
        $collection->add($persona);
    }
}
