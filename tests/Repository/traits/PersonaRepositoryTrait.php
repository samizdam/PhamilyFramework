<?php

namespace Phamily\tests\Repository\traits;

use Phamily\Framework\Repository\PersonaRepository;
use Phamily\tests\DbTest;

/**
 * @author samizdam
 */
trait PersonaRepositoryTrait
{
    protected function getRepository()
    {
        $repository = new PersonaRepository(DbTest::getDbAdapter());

        return $repository;
    }
}
