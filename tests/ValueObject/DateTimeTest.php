<?php

namespace Phamily\Framework\ValueObject;

use Phamily\tests\UnitTest;

class DateTimeTest extends UnitTest
{
    public function testBaseUsage()
    {
        $time = time();
        $date = new DateTime();
        $date->setTimestamp($time);

        $this->assertEquals(date(DATE_ATOM, $time), $date->format(DATE_ATOM));
    }
}
