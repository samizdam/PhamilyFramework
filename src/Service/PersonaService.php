<?php

namespace phamily\framework\Service;

use phamily\framework\Model\Persona;
use phamily\framework\Model\PersonaInterface;
use phamily\framework\ValueObject\DateTimeInterface;
use phamily\framework\Repository\PersonaRepositoryInterface;
use phamily\framework\Service\Proxy\PersonaRepositoryProxy;
use phamily\framework\traits\BitmaskTrait;

class PersonaService implements PersonaServiceInterface
{
    use BitmaskTrait;

    protected $repository;

    public function __construct()
    {
        $this->repository = new PersonaRepositoryProxy();
    }

    public function useRepository(PersonaRepositoryInterface $repository)
    {
        $this->repository->setRepository($repository);
    }

    public function isRepositoryUsed()
    {
        return $this->repository->isActive();
    }

    public function create($gender = self::GENDER_UNDEFINED, array $names = [], PersonaInterface $father = null, PersonaInterface $mother = null, DateTimeInterface $dateOfBirth = null, DateTimeInterface $dateOfDeath = null)
    {
        $persona = new Persona($gender, $names);

        $this->repository->save($persona);

        return $persona;
    }

    public function getById($id, $fetchWithOptions = self::ALL_KINSHIP)
    {
        return $this->repository->getById($id, $fetchWithOptions);
    }

    public function delete(PersonaInterface &$persona)
    {
        $this->repository->delete($persona);

        /*
         * destroy object
         */
        $persona = null;
    }

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS)
    {
        return $this->repository->getSiblings($persona, $degreeOfKinship);
    }
}
