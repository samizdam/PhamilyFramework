<?php
namespace Phamily\Framework\Util;

use Phamily\tests\UnitTest;

/**
 *
 * @author samizdam
 *
 */
class DatabaseConfigAdapterTest extends UnitTest
{

    public function testAdaptPhinxToZend()
    {
        $adapter = new DatabaseConfigAdapter();
        $config = [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'name',
            'user' => 'user',
            'pass' => 'pass',
            'schema' => 'public'
        ];
        $result = $adapter->adaptPhinxToZend($config);
        $this->assertEquals('Pdo_Pgsql', $result['driver']);
    }
}