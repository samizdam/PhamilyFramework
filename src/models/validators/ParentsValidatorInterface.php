<?php
namespace phamily\framework\models\validators;

use phamily\framework\models\PersonaInterface;

interface ParentsValidatorInterface extends ValidatorInterface{
	public function isValidFather(PersonaInterface $persona, PersonaInterface $father);
	public function isValidMother(PersonaInterface $persona, PersonaInterface $mother);
}