<?php

namespace Phamily\tests\Service\traits;

use Phamily\Framework\Repository\PersonaRepository;
use Phamily\Framework\Service\PersonaService;

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
