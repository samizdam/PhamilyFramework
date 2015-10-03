<?php
namespace phamily\framework\collections;

interface ChildrenCollectionInterface extends PersonaCollectionInterface
{

    public function getParent();
}