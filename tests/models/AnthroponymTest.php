<?php
namespace phamily\tests\models;

use phamily\framework\models\Anthroponym;
use phamily\tests\UnitTest;

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