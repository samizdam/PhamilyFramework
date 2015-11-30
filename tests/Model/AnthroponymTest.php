<?php

namespace Phamily\Framework\Model;

use Phamily\tests\UnitTest;

/**
 * @author samizdam
 */
class AnthroponymTest extends UnitTest
{
    public function testAnthroponymCreating()
    {
        $type = 'simpleName';
        $value = 'Vasya';
        $anthroponym = new Anthroponym($type, $value);
        $this->assertEquals($value, $anthroponym->getValue());
    }
}
