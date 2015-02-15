<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\exceptions\OutOfBoundsException;

class SpouseCollection extends AbstractPersonaCollection implements SpouseCollectionInterface{
	
	protected function validateAddition(PersonaInterface $persona){
		return true;
	}
}