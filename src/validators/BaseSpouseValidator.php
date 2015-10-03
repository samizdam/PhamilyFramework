<?php
namespace phamily\framework\validators;

use phamily\framework\models\PersonaInterface;

class BaseSpouseValidator extends AbstractValidator implements SpouseValidatorInterface
{

    public function isValidSpouse(PersonaInterface $persona, PersonaInterface $spouse)
    {
        $errors = [];
        
        if ($persona === $spouse) {
            $errors[] = "Persona can't be spouse for self";
        }
        if ($persona->getGender() === self::GENDER_UNDEFINED || $spouse->getGender() === self::GENDER_UNDEFINED) {
            $errors[] = "Both spouses must have the gender. ";
        }
        if ($persona->getGender() === $spouse->getGender()) {
            $errors[] = "Spouses must be of different genders. ";
        }
        if ($persona->hasDateOfBirth() && $spouse->hasDateOfDeath()) {
            if ($persona->getDateOfBirth() >= $spouse->getDateOfDeath()) {
                $errors[] = "Persona can't born after spouse death. ";
            }
        }
        if ($persona->hasDateOfDeath() && $spouse->hasDateOfBirth()) {
            if ($persona->getDateOfDeath() <= $spouse->getDateOfBirth()) {
                $errors[] = "Persona can't dead before spouse will born. ";
            }
        }
        
        return $this->getResult($errors);
    }
}