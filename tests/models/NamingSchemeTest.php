<?php
use phamily\framework\models\NamingScheme;
use phamily\framework\models\NameCollectionInterface;
class NamingSchemeTest extends UnitTest{
	public function testConstruct(){
		$type = 'fio';
		$config = $this->getSchemeConfigSample();
		
		$scheme = new NamingScheme($type, $config);
		
		$this->assertEquals($type, $scheme->getType());
		$this->assertEquals($config, $scheme->getConfig());
	}
	
// 	public function testConstructWithSingleDefaultForm(){
// 		$scheme = new NamingScheme('fio', ['formula' => function(){}]);
// 		$this->assertTrue($scheme->hasForm('default'));
// 	}
	
	public function testSchemeHasDefaultForm(){
		$scheme = new NamingScheme('fio', $this->getSchemeConfigSample());
		$this->assertTrue($scheme->hasForm('default'));
	}
	
	public function testSchemeHasNotSomeForm(){
		$scheme = new NamingScheme('fio', $this->getSchemeConfigSample());
		$this->assertFalse($scheme->hasForm('someForm'));
	}
	
	private function getSchemeConfigSample(){
		return  [
			'default' => [
				'formula' => function(NameCollectionInterface $names){
					return join(' ', $names);
				} 
			],
			 
		];
	}
}