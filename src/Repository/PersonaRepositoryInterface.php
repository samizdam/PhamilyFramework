<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\KinshipAwareInterface;
use Phamily\Framework\Collection\PersonaCollectionInterface;

/**
 *
 * @author samizdam
 *
 */
interface PersonaRepositoryInterface extends KinshipAwareInterface
{

    /**
     *
     *
     * @param PersonaInterface $persona
     * @return PersonaInterface
     */
    public function save(PersonaInterface $persona);

    /**
     *
     *
     * @param mixed $id
     * @param int $fetchWithOptions
     * @return PersonaInterface
     */
    public function getPersonaById($id, $fetchWithOptions = self::WITHOUT_KINSHIP);

    /**
     *
     *
     * @param PersonaInterface $persona
     * @param unknown $degreeOfKinship
     * @return PersonaCollectionInterface
     */
    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS);

    /**
     *
     *
     * @param PersonaInterface $persona
     * @return void
     */
    public function delete(PersonaInterface $persona);
}
