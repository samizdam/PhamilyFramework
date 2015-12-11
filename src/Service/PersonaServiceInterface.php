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
     */
    public function createPersona($gender, array $names = [], PersonaInterface $father = null, PersonaInterface $mother = null, DateTimeInterface $dateOfBirth = null, DateTimeInterface $dateOfDeath = null);

    public function delete(PersonaInterface &$persona);

    public function getById($id, $fetchWithOptions = self::ALL_KINSHIP);

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    // public function findByNames(array $names = []){

    // }
}
