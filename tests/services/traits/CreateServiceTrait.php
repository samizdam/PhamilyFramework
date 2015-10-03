<?php
namespace phamily\tests\services\traits;

use phamily\framework\repositories\PersonaRepository;
use phamily\framework\services\PersonaService;

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