<?php
namespace phamily\framework\models\validators;

use phamily\framework\models\PersonaInterface;

class BaseParentsValidator implements ParentsValidatorInterface{
	
	public function isValidFather(PersonaInterface $persona, PersonaInterface $father){
		/*
		 * TODO to decide: use exceptions (and refuse 'isValid' signature for favore 'checkSomething'
		 * and where is messages? 
		 */
		return ($father->getGender() === $father::GENDER_MALE);
	}
	
	public function isValidMother(PersonaInterface $persona, PersonaInterface $mother){
		return ($mother->getGender() === $mother::GENDER_FEMALE);
	}	
}