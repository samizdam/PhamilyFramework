<?php
namespace phamily\framework\models\validators;

use phamily\framework\models\PersonaInterface;

class BaseParentsValidator implements ParentsValidatorInterface{
	
	private $errors = [];
	
	public function isValidFather(PersonaInterface $persona, PersonaInterface $father){
		$errors = [];

		if($father->getGender() !== $father::GENDER_MALE){
			$errors[] = "Father must be a male";
		}
		if($father->hasDateOfBirth() && $persona->hasDateOfBirth()
				 && $father->getDateOfBirth('Y') >= $persona->getDateOfBirth('Y')){
			$errors[] = "Child must be younger than the parent";
		}
		
		return $this->getResult($errors);
	}
	
	public function isValidMother(PersonaInterface $persona, PersonaInterface $mother){
		$errors = [];
		
		if ($mother->getGender() !== $mother::GENDER_FEMALE){
			$errors[] = "Mother must be a female";
		}

		if(($mother->hasDateOfBirth() && $persona->hasDateOfBirth()) 
				&& (int) $mother->getDateOfBirth('Y') >= (int) $persona->getDateOfBirth('Y')){
			$errors[] = "Child must be younger than the parent";
		}		
		
		return $this->getResult($errors);
	}	
	
	
	public function getErrors(){
		return $this->errors;
	}
	
	protected function getResult($errors){
		$this->errors = $errors;
		return (count($this->errors) === 0);
	}
}