<?php

namespace Phamily\Framework\Collection;

interface ChildrenCollectionInterface extends PersonaCollectionInterface
{
    public function getParent();
}
