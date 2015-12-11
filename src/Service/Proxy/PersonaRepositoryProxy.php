<?php

namespace Phamily\Framework\Service\Proxy;

use Phamily\Framework\Repository\PersonaRepositoryInterface;
use Phamily\Framework\Model\PersonaInterface;

class PersonaRepositoryProxy implements PersonaRepositoryInterface
{
    protected $repository;

    protected $active = false;

    public function __construct(PersonaRepositoryInterface $repository = null)
    {
        if (isset($repository)) {
            $this->setRepository($repository);
        }
    }

    public function setRepository(PersonaRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->active = true;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function save(PersonaInterface $persona)
    {
        if ($this->isActive()) {
            return $this->repository->save($persona);
        }
    }

    public function delete(PersonaInterface $persona)
    {
        if ($this->isActive()) {
            return $this->repository->delete($persona);
        }
    }

    public function getPersonaById($id, $fetchWithOptions = self::WITHOUT_KINSHIP)
    {
        if ($this->isActive()) {
            return $this->repository->getPersonaById($id, $fetchWithOptions);
        }
    }

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS)
    {
        if ($this->isActive()) {
            return $this->repository->getSiblings($persona, $degreeOfKinship);
        }
    }
}
