<?php

namespace phamily\framework\services\proxies;

use phamily\tests\DbTest;
use phamily\tests\services\traits\CreateServiceTrait;
use phamily\framework\repositories\PersonaRepository;

/**
 * @author samizdam
 */
class PersonRepositoryProxyTest extends DbTest
{
    use CreateServiceTrait;

    public function testConstructActiveProxy()
    {
        $repository = new PersonaRepository($this->getDbAdapter());
        $proxy = new PersonaRepositoryProxy($repository);
        $this->assertTrue($proxy->isActive());
    }
}
