<?php

namespace Phamily\Framework\Collection;

use Phamily\Framework\GenderAwareInterface;
use Phamily\Framework\Model\PersonaInterface;

interface PersonaCollectionInterface extends \Countable, \SeekableIterator, GenderAwareInterface
{
    public function add(PersonaInterface $persona);

    public function contains(PersonaInterface $persona);
}
