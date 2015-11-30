<?php

namespace phamily\framework\Service;

use phamily\framework\Model\PersonaInterface;
use phamily\framework\GenderAwareInterface;
use phamily\framework\value_objects\DateTimeInterface;
use phamily\framework\KinshipAwareInterface;

interface PersonaServiceInterface extends GenderAwareInterface, KinshipAwareInterface
{
    public function create($gender, array $names = [], PersonaInterface $father = null, PersonaInterface $mother = null, DateTimeInterface $dateOfBirth = null, DateTimeInterface $dateOfDeath = null);

    public function delete(PersonaInterface &$persona);

    public function getById($id, $fetchWithOptions = self::ALL_KINSHIP);

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    // public function findByNames(array $names = []){

    // }
}
