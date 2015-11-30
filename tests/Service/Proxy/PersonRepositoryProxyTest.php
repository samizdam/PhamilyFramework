<?php

namespace Phamily\Framework\Service\Proxy;

use Phamily\tests\DbTest;
use Phamily\Framework\Repository\PersonaRepository;
use Phamily\tests\Service\traits\CreateServiceTrait;

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
