<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\OutOfBoundsException;

class ChildrenCollection extends AbstractPersonaCollection implements ChildrenCollectionInterface{
		
	/*
	 * ChildrenCollectionInterface implemantation
	 */
	
	protected function validateAddition(PersonaInterface $persona){
		if($this->contains($persona)){
			throw new LogicException("Persona already has this child");
		}
		if($this->persona === $persona){
			throw new LogicException("Persona can't be parent for self");
		}
		return true;
	}
	
}