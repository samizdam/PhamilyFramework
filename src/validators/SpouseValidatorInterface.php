<?php
namespace phamily\framework\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\GenderAwareInterface;

interface SpouseValidatorInterface extends ValidatorInterface, GenderAwareInterface{
	
	public function isValidSpouse(PersonaInterface $persona, PersonaInterface $spouse);
	
}