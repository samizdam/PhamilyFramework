<?php

namespace phamily\framework\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\Collection\ChildrenCollectionInterface;
use phamily\framework\GenderAwareInterface;

interface ChildrenValidatorInreface extends ValidatorInterface, GenderAwareInterface
{
    public function isValidChild(ChildrenCollectionInterface $collection, PersonaInterface $child);
}
