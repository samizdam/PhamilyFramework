<?php

namespace Phamily\Framework\Validator;

use Phamily\Framework\Model\PersonaInterface;

class FakeTrueValidator extends AbstractValidator implements SpouseValidatorInterface
{
    public function isValidSpouse(PersonaInterface $persona, PersonaInterface $spouse)
    {
        return true;
    }
}
