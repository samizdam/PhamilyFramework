<?php

namespace phamily\framework\validators;

use phamily\framework\Model\PersonaInterface;

class FakeTrueValidator extends AbstractValidator implements SpouseValidatorInterface
{
    public function isValidSpouse(PersonaInterface $persona, PersonaInterface $spouse)
    {
        return true;
    }
}
