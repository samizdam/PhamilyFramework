<?php

namespace Phamily\Framework\Service;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\GenderAwareInterface;
use Phamily\Framework\ValueObject\DateTimeInterface;
use Phamily\Framework\KinshipAwareInterface;

/**
 *
 * @author samizdam
 *
 */
interface PersonaServiceInterface extends GenderAwareInterface, KinshipAwareInterface
{
    /**
     * Create new Persona with given attributes.
     *
     * @param string $gender
     * @param array $names
     * @param PersonaInterface $father
     * @param PersonaInterface $mother
     * @param DateTimeInterface $dateOfBirth
     * @param DateTimeInterface $dateOfDeath
     * @return PersonaInterface
     */
    public function createPersona($gender, array $names = [], PersonaInterface $father = null, PersonaInterface $mother = null, DateTimeInterface $dateOfBirth = null, DateTimeInterface $dateOfDeath = null);

    /**
     * Delete given persona from persistent storage.
     *
     * @param PersonaInterface $persona
     * @return void
     */
    public function deletePersona(PersonaInterface &$persona);


    /**
     * Fetch Persona object with given ID from persistent storage with required kinship.
     *
     * @param mixed $id
     * @param int $fetchWithOptions
     * @return PersonaInterface
     */
    public function getPersonaById($id, $fetchWithOptions = self::ALL_KINSHIP);

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    // public function findByNames(array $names = []){

    // }
}
