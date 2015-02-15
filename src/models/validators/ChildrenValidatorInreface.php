<?php
namespace phamily\framework\models\validators;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\collections\ChildrenCollectionInterface;
use phamily\framework\GenderAwareInterface;

interface ChildrenValidatorInreface extends ValidatorInterface, GenderAwareInterface{
	
	public function isValidChild(ChildrenCollectionInterface $collection, PersonaInterface $child);
	
}