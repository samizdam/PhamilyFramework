<?php
namespace phamily\tests\models\collections;

use phamily\tests\UnitTest;
use phamily\tests\models\traits\PersonaStubTrait;
use phamily\framework\models\collections\ChildrenCollection;

class ChildrenCollectionTest extends UnitTest{
	
	use PersonaStubTrait;
	const EXCEPTION_BASE_NS = '\\phamily\\framework\\models\\exceptions\\';
	public function testPutToCollection(){
		$parent = $this->createPersonaStub();
		$collection = new ChildrenCollection($parent);
		
		$childA = $this->createPersonaStub();
		$childB = $this->createPersonaStub();
		
		$collection->add($childA);
		$collection->add($childB);
		
		$this->assertEquals(2, $collection->count());
	}
	
	public function testDoubleChildAddException(){
		$parent = $this->createPersonaStub();
		$collection = new ChildrenCollection($parent);
		
		$childA = $this->createPersonaStub();
		
		$collection->add($childA);
		$this->setExpectedException(self::EXCEPTION_BASE_NS . 'LogicException');
		$collection->add($childA);
	}
	
	public function testSeekSuccess(){
		$parent = $this->createPersonaStub();
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
	
	public function testSeekException(){
		$parent = $this->createPersonaStub();
		$collection = new ChildrenCollection($parent);
		
		$child = $this->createPersonaStub();
		$collection->add($child);
		
		$this->setExpectedException(self::EXCEPTION_BASE_NS . 'OutOfBoundsException');
		$collection->seek(5);
	}
	
	public function testParentSelfChildException(){
		$parent = $this->createPersonaStub();
		$collection = new ChildrenCollection($parent);
		
		$this->setExpectedException(self::EXCEPTION_BASE_NS . 'LogicException');
		$collection->add($parent);
	}
}