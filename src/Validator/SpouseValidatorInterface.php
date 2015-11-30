<?php

namespace Phamily\Framework\Validator;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\GenderAwareInterface;

interface SpouseValidatorInterface extends ValidatorInterface, GenderAwareInterface
{
    public function isValidSpouse(PersonaInterface $persona, PersonaInterface $spouse);
}
