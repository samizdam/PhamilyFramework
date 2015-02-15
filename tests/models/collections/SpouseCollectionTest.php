<?php
namespace phamily\tests\models\collections;

use phamily\tests\UnitTest;
use phamily\tests\models\traits\PersonaStubTrait;
use phamily\framework\models\collections\SpouseCollection;

class SpouseCollectionTest extends UnitTest{
	
	use PersonaStubTrait;
	
	public function testAddToCollection(){
		$husband = $this->createPersonaStub(SpouseCollection::GENDER_MALE);
		$wife = $this->createPersonaStub(SpouseCollection::GENDER_FEMALE);
		
		$collection = new SpouseCollection($husband);
		$collection->add($wife);
		
		$this->assertContains($wife, $collection);
	}
	
}