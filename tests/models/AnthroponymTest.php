<?php
namespace phamily\tests\models;

use phamily\framework\models\Anthroponym;
use phamily\tests\UnitTest;

class AnthroponymTest extends UnitTest{
	public function testAnthroponymCreating(){
		$type = 'simpleName';
		$value = 'Vasya';
		$anthroponym = new Anthroponym($type, $value);
		$this->assertEquals($value, $anthroponym->getValue());
	}
	
	public function testIsMultiple(){
		$type = 'middleName';
		$value = ['Philip', 'Arthur', 'George'];
		$anthroponym = new Anthroponym($type, $value);
		$this->assertTrue($anthroponym->isMultiple());
	}	

}