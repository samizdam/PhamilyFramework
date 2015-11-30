<?php

namespace Phamily\Framework\Validator;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\GenderAwareInterface;

interface ParentsValidatorInterface extends ValidatorInterface, GenderAwareInterface
{
    public function isValidFather(PersonaInterface $persona, PersonaInterface $father);

    public function isValidMother(PersonaInterface $persona, PersonaInterface $mother);
}
