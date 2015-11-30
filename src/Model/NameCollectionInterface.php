<?php

namespace Phamily\Framework\Model;

interface NameCollectionInterface extends \ArrayAccess
{
    // public function setScheme($scheme);
    public function add(AnthroponymInterface $name);

    public function remove(AnthroponymInterface $name);
}
