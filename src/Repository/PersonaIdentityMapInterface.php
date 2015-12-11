<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\PersonaInterface;

/**
 * TODO it is Identity Map, needs renamimng.
 * 
 * @author samizdam
 */
interface PersonaIdentityMapInterface
{
    public function add(PersonaInterface $persona, $rowData);

    public function getObject($id);

    public function getData($id);

    public function has($id);

    public function remove($id);
}
