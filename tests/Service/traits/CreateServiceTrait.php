<?php

namespace phamily\tests\Service\traits;

use phamily\framework\Repository\PersonaRepository;
use phamily\framework\Service\PersonaService;

/**
 * @author samizdam
 */
trait CreateServiceTrait
{
    protected function createServiceWithRepository()
    {
        $repository = new PersonaRepository($this->getDbAdapter());
        $service = new PersonaService();

        $service->useRepository($repository);

        return $service;
    }
}
