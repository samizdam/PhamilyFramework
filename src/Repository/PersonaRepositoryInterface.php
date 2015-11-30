<?php

namespace phamily\framework\Repository;

use phamily\framework\Model\PersonaInterface;
use phamily\framework\KinshipAwareInterface;

interface PersonaRepositoryInterface extends KinshipAwareInterface
{
    public function save(PersonaInterface $persona);

    public function getById($id, $fetchWithOptions = self::WITHOUT_KINSHIP);

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    public function delete(PersonaInterface $persona);
}
