<?php

namespace phamily\framework\Collection;

use phamily\tests\UnitTest;
use phamily\framework\models\traits\PersonaStubTrait;
use phamily\framework\models\exceptions;

/**
 * @author samizdam
 */
class ChildrenCollectionTest extends UnitTest
{
    use PersonaStubTrait;

    public function testPutToCollection()
    {
        $parent = $this->createPersonaStub(ChildrenCollection::GENDER_MALE);
        $collection = new ChildrenCollection($parent);

        $childA = $this->createPersonaStub();
        $childB = $this->createPersonaStub();

        $collection->add($childA);
        $collection->add($childB);

        $this->assertEquals(2, $collection->count());
    }

    public function testDoubleChildAddException()
    {
        $parent = $this->createPersonaStub(ChildrenCollection::GENDER_MALE);
        $collection = new ChildrenCollection($parent);

        $childA = $this->createPersonaStub();

        $collection->add($childA);
        $this->setExpectedException(exceptions\LogicException::class);
        $collection->add($childA);
    }

    public function testSeekSuccess()
    {
        $parent = $this->createPersonaStub(ChildrenCollection::GENDER_MALE);
        $collection = new ChildrenCollection($parent);

        $childA = $this->createPersonaStub();
        $childB = $this->createPersonaStub();
        $collection->add($childA);
        $collection->add($childB);

        $collection->seek(1);
        $this->assertEquals(1, $collection->key());
        $this->assertEquals($childB, $collection->current());

        $collection->rewind();
        $this->assertEquals(0, $collection->key());
        $this->assertEquals($childA, $collection->current());
    }

    public function testSeekException()
    {
        $parent = $this->createPersonaStub(ChildrenCollection::GENDER_MALE);
        $collection = new ChildrenCollection($parent);

        $child = $this->createPersonaStub();
        $collection->add($child);

        $this->setExpectedException(exceptions\OutOfBoundsException::class);
        $collection->seek(5);
    }

    public function testParentSelfChildException()
    {
        $parent = $this->createPersonaStub(ChildrenCollection::GENDER_MALE);
        $collection = new ChildrenCollection($parent);

        $this->setExpectedException(exceptions\LogicException::class);
        $collection->add($parent);
    }
}
