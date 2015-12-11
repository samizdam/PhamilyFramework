<?php

namespace Phamily\Framework\Service;

use Phamily\Framework\Model\Persona;
use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\ValueObject\DateTimeInterface;
use Phamily\Framework\Repository\PersonaRepositoryInterface;
use Phamily\Framework\Service\Proxy\PersonaRepositoryProxy;
use Phamily\Framework\Util\BitmaskTrait;

/**
 * Facade for CRUD and find Persona.
 *
 * @author samizdam
 *
 */
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

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Service\PersonaServiceInterface::createPersona()
     *
     */
    public function createPersona($gender = self::GENDER_UNDEFINED, array $names = [], PersonaInterface $father = null, PersonaInterface $mother = null, DateTimeInterface $dateOfBirth = null, DateTimeInterface $dateOfDeath = null)
    {
        $persona = new Persona($gender, $names);

        $this->repository->save($persona);

        return $persona;
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Service\PersonaServiceInterface::getPersonaById()
     *
     */
    public function getPersonaById($id, $fetchWithOptions = self::ALL_KINSHIP)
    {
        return $this->repository->getPersonaById($id, $fetchWithOptions);
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Service\PersonaServiceInterface::deletePersona()
     *
     */
    public function deletePersona(PersonaInterface &$persona)
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
