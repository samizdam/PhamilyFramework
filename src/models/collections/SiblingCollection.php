<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;

class SiblingCollection extends AbstractPersonaCollection{
	protected function validateAddition(PersonaInterface $persona){
		return true;
	} 
}