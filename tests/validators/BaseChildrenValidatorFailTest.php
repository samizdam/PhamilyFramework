<?php

namespace phamily\framework\validators;

use phamily\tests\UnitTest;
use phamily\framework\models\traits\PersonaStubTrait;
use phamily\framework\Collection\ChildrenCollection;

/**
 * @author samizdam
 */
class BaseChildrenValidatorFailTest extends UnitTest
{
    use PersonaStubTrait;

    public function testGenderlessParent()
    {
        $validator = new BaseChildrenValidator();
        $parent = $this->createPersonaStub();
        $collection = new ChildrenCollection($parent);
        $child = $this->createPersonaStub();

        $this->assertFalse($validator->isValidChild($collection, $child));
    }

    public function testSelfParent()
    {
        $validator = new BaseChildrenValidator();
        $parent = $this->createPersonaStub();
        $collection = new ChildrenCollection($parent);

        $this->assertFalse($validator->isValidChild($collection, $parent));
    }

    public function testAlreadyHasChild()
    {
        $validator = new BaseChildrenValidator();
        $parent = $this->createPersonaStub($validator::GENDER_MALE);
        $collection = new ChildrenCollection($parent);
        $child = $this->createPersonaStub();
        $collection->add($child);

        $this->assertFalse($validator->isValidChild($collection, $child));
    }
}
