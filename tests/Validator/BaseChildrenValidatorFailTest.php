<?php

namespace Phamily\Framework\Validator;

use Phamily\tests\UnitTest;
use Phamily\Framework\Model\traits\PersonaStubTrait;
use Phamily\Framework\Collection\ChildrenCollection;

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
