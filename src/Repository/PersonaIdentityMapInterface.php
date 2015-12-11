<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\PersonaInterface;

/**
 * In-memory cache.
 *
 * @author samizdam
 */
interface PersonaIdentityMapInterface
{
    /**
     * TODO: type hint
     *
     * @param PersonaInterface $persona
     * @param  $rowData
     * @return void
     */
    public function add(PersonaInterface $persona, $rowData);

    /**
     *
     *
     * @param mixed $id
     * @return PersonaInterface
     */
    public function getObject($id);

    /**
     *
     *
     * @param mixed $id
     * @return mixed
     */
    public function getData($id);

    /**
     *
     *
     * @param mixed $id
     * @return bool
     */
    public function has($id);

    /**
     *
     *
     * @param mixed $id
     * @return bool
     */
    public function remove($id);
}
