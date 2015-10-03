<?php
namespace phamily\tests\repositories\traits;

use phamily\framework\repositories\PersonaRepository;
use phamily\tests\DbTest;

trait PersonaRepositoryTrait
{

    protected function getRepository()
    {
        $repository = new PersonaRepository(DbTest::getDbAdapter());
        return $repository;
    }
}