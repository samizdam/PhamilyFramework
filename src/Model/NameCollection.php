<?php

namespace phamily\framework\Model;

class NameCollection extends \ArrayObject implements NameCollectionInterface
{
    public function __construct(array $namesArray = [])
    {
        foreach ($namesArray as $name) {
            $this->add($name);
        }
    }

    public function add(AnthroponymInterface $name)
    {
        $this->offsetSet($name->getType(), $name);
    }

    public function remove(AnthroponymInterface $name)
    {
        $this->offsetUnset($name->getType());
    }
}
