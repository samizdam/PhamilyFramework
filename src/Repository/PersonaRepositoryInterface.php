<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\KinshipAwareInterface;

interface PersonaRepositoryInterface extends KinshipAwareInterface
{
    public function save(PersonaInterface $persona);

    public function getPersonaById($id, $fetchWithOptions = self::WITHOUT_KINSHIP);

    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    public function delete(PersonaInterface $persona);
}
