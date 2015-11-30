<?php

namespace Phamily\Framework\Service;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\GenderAwareInterface;
use Phamily\Framework\ValueObject\DateTimeInterface;
use Phamily\Framework\KinshipAwareInterface;

interface PersonaServiceInterface extends GenderAwareInterface, KinshipAwareInterface
{
    public function create($gender, array $names = [], PersonaInterface $father = null, PersonaInterface $mother = null, DateTimeInterface $dateOfBirth = null, DateTimeInterface $dateOfDeath = null);

    public function delete(PersonaInterface &$persona);

    public function getById($id, $fetchWithOptions = self::ALL_KINSHIP);

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    // public function findByNames(array $names = []){

    // }
}
