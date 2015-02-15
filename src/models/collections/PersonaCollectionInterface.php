<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;
use phamily\framework\GenderAwareInterface;

interface PersonaCollectionInterface extends \Countable, \SeekableIterator, GenderAwareInterface{
	
	public function add(PersonaInterface $persona);
	
}