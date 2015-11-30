<?php

namespace phamily\framework\Model;

use phamily\tests\UnitTest;

/**
 * @author samizdam
 */
class NameCollectionTest extends UnitTest
{
    public function testAddNameToCollection()
    {
        $nameMock = $this->getAnthroponymMock();

        $collection = new NameCollection();

        $collection->add($nameMock);
        $this->assertContains($nameMock, $collection);
    }

    public function testRemoveNameFromCollection()
    {
        $nameMock = $this->getAnthroponymMock();
        $nameMock->method('getType')->willReturn('firstName');

        $collection = new NameCollection([
            $nameMock,
        ]);

        $this->assertContains($nameMock, $collection);
        $collection->remove($nameMock);
        $this->assertNotContains($nameMock, $collection);
    }

    private function getAnthroponymMock()
    {
        return $this->getMockBuilder(\phamily\framework\Model\AnthroponymInterface::class)->getMock();
    }
}