<?php

namespace phamily\framework\Validator;

use phamily\framework\Model\PersonaInterface;
use phamily\framework\GenderAwareInterface;

interface SpouseValidatorInterface extends ValidatorInterface, GenderAwareInterface
{
    public function isValidSpouse(PersonaInterface $persona, PersonaInterface $spouse);
}
