<?php
namespace phamily\tests\services\proxies;

use phamily\tests\DbTest;
use phamily\tests\services\traits\CreateServiceTrait;
use phamily\framework\services\proxies\PersonaRepositoryProxy;
use phamily\framework\repositories\PersonaRepository;

class PersonaRepositoryProxyTest extends DbTest
{
    use CreateServiceTrait;

    public function testConstructActiveProxy()
    {
        $repository = new PersonaRepository($this->getDbAdapter());
        $proxy = new PersonaRepositoryProxy($repository);
        $this->assertTrue($proxy->isActive());
    }
}