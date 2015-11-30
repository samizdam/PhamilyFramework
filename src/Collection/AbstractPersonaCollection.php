<?php

namespace phamily\framework\Collection;

use phamily\framework\Model\PersonaInterface;
use phamily\framework\Model\exceptions\OutOfBoundsException;

abstract class AbstractPersonaCollection implements PersonaCollectionInterface
{
    protected $persona;

    public function __construct(PersonaInterface $persona)
    {
        $this->persona = $persona;
    }

    abstract protected function validateAddition(PersonaInterface $persona);

    /*
     * PersonaCollectionInterface implemantation
     */
    protected $items = [];

    public function add(PersonaInterface $persona)
    {
        if ($this->validateAddition($persona)) {
            $this->items[] = $persona;
        }
    }

    public function contains(PersonaInterface $persona)
    {
        return in_array($persona, $this->items, true);
    }

    /*
     * SPL Countable implementation
     */
    public function count()
    {
        return count($this->items);
    }

    /*
     * SPL SeekableIterator implementation
     */
    protected $position = 0;

    public function seek($position)
    {
        if ($position >= $this->count()) {
            throw new OutOfBoundsException("Persona has only {$this->count()} spouses");
        }
        $this->position = $position;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->position < $this->count();
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
