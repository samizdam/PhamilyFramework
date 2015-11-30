<?php

namespace phamily\framework\Collection;

interface ChildrenCollectionInterface extends PersonaCollectionInterface
{
    public function getParent();
}
