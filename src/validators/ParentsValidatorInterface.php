<?php
namespace phamily\framework\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\GenderAwareInterface;

interface ParentsValidatorInterface extends ValidatorInterface, GenderAwareInterface{
	public function isValidFather(PersonaInterface $persona, PersonaInterface $father);
	public function isValidMother(PersonaInterface $persona, PersonaInterface $mother);
}