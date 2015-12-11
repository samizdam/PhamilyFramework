<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\PersonaInterface;

/**
 *
 * @author samizdam
 *
 */
class PersonaIdentityMap implements PersonaIdentityMapInterface
{
    protected $items = [];

    /**
     * TODO: use special object PersonaRow (ext.
     * RowGateway?) instead of $rowData,
     * that can be using as prototype for ResultSet in TableGateway.
     *
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaIdentityMapInterface::add($persona, $rowData)
     *
     */
    public function add(PersonaInterface $persona, $rowData, $options = 0)
    {
        $this->items[$persona->getId()] = [
            'object' => $persona,
            'data' => $rowData,
            'options' => $options,
        ];
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaIdentityMapInterface::getObject()
     *
     */
    public function getObject($id)
    {
        return $this->items[$id]['object'];
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaIdentityMapInterface::getData()
     *
     */
    public function getData($id)
    {
        return $this->items[$id]['data'];
    }

    /**
     *
     *
     * @param mixed $id
     * @return mixed
     */
    public function getOptions($id)
    {
        return $this->items[$id]['options'];
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaIdentityMapInterface::has()
     *
     */
    public function has($id)
    {
        return isset($this->items[$id]);
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaIdentityMapInterface::remove()
     *
     */
    public function remove($id)
    {
        unset($this->items[$id]);
    }
}
