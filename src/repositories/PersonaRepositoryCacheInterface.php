<?php

namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;

/**
 * TODO it is Identity Map, needs renamimng.
 * 
 * @author samizdam
 */
interface PersonaRepositoryCacheInterface
{
    public function add(PersonaInterface $persona, $rowData);

    public function getObject($id);

    public function getData($id);

    public function has($id);

    public function remove($id);
}
