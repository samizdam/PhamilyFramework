<?php

namespace phamily\tests\Repository\traits;

use phamily\framework\Repository\PersonaRepository;
use phamily\tests\DbTest;

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
