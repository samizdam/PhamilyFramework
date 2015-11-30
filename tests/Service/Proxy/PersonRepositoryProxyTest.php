<?php

namespace phamily\framework\Service\Proxy;

use phamily\tests\DbTest;
use phamily\framework\Repository\PersonaRepository;
use phamily\tests\Service\traits\CreateServiceTrait;

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
