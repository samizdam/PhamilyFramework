<?php
namespace phamily\tests\value_objects;

use phamily\framework\value_objects\DateTime;
use phamily\tests\UnitTest;

class DateTimeTest extends UnitTest{
	public function testBaseUsage(){
		$time = time();
		$date = new DateTime();
		$date->setTimestamp($time);
		
		$this->assertEquals(date(DATE_ATOM, $time), $date->format(DATE_ATOM));
	}
}