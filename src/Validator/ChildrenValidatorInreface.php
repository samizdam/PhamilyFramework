<?php

namespace Phamily\Framework\Validator;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\Collection\ChildrenCollectionInterface;
use Phamily\Framework\GenderAwareInterface;

interface ChildrenValidatorInreface extends ValidatorInterface, GenderAwareInterface
{
    public function isValidChild(ChildrenCollectionInterface $collection, PersonaInterface $child);
}
