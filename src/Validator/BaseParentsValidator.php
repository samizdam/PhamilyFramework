<?php

namespace phamily\framework\Validator;

use phamily\framework\Model\PersonaInterface;

class BaseParentsValidator extends AbstractValidator implements ParentsValidatorInterface
{
    public function isValidFather(PersonaInterface $persona, PersonaInterface $father)
    {
        $errors = [];

        if ($father->getGender() !== self::GENDER_MALE) {
            $errors[] = 'Father must be a male';
        }
        if ($father->hasDateOfBirth() && $persona->hasDateOfBirth() && $father->getDateOfBirth('Y') >= $persona->getDateOfBirth('Y')) {
            $errors[] = 'Child must be younger than the parent';
        }

        return $this->getResult($errors);
    }

    public function isValidMother(PersonaInterface $persona, PersonaInterface $mother)
    {
        $errors = [];

        if ($mother->getGender() !== self::GENDER_FEMALE) {
            $errors[] = 'Mother must be a female';
        }

        if (($mother->hasDateOfBirth() && $persona->hasDateOfBirth()) && (int) $mother->getDateOfBirth('Y') >= (int) $persona->getDateOfBirth('Y')) {
            $errors[] = 'Child must be younger than the parent';
        }

        return $this->getResult($errors);
    }
}
