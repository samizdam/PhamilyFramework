<?php
namespace phamily\framework\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\collections\ChildrenCollectionInterface;

class BaseChildrenValidator extends AbstractValidator implements ChildrenValidatorInreface{
	
	public function isValidChild(ChildrenCollectionInterface $collection, PersonaInterface $child){
		$errors = [];
		
		if($collection->getParent()->getGender() === self::GENDER_UNDEFINED){
			$errors[] = "Can't add child for genderless persona";
		}
		if($collection->contains($child)){
			$errors[] = "Persona already has this child";
		}
		if($collection->getParent() === $child){
			$errors[] = "Child can't be parent for self";
		}

		return $this->getResult($errors);
	}
}