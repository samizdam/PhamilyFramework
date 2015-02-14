<?php
namespace phamily\tests\models;

use phamily\tests\UnitTest;
use phamily\tests\models\traits\PersonaStubTrait;
use phamily\framework\models\ChildCollection;

class ChildCollectionTest extends UnitTest{
	
	use PersonaStubTrait;
	const EXCEPTION_BASE_NS = '\\phamily\\framework\\models\\exceptions\\';
	public function testPutToCollection(){
		$parent = $this->createPersonaStub();
		$collection = new ChildCollection($parent);
		
		$childA = $this->createPersonaStub();
		$childB = $this->createPersonaStub();
		
		$collection->add($childA);
		$collection->add($childB);
		
		$this->assertEquals(2, $collection->count());
	}
	
	public function testDoubleChildAddException(){
		$parent = $this->createPersonaStub();
		$collection = new ChildCollection($parent);
		
		$childA = $this->createPersonaStub();
		
		$collection->add($childA);
		$this->setExpectedException(self::EXCEPTION_BASE_NS . 'LogicException');
		$collection->add($childA);
	}
}