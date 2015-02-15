<?php
namespace phamily\framework\models\collections;

use phamily\framework\GenderAwareInterface;
use phamily\framework\models\PersonaInterface;

interface PersonaCollectionInterface extends \Countable, \SeekableIterator, GenderAwareInterface{
	
	public function add(PersonaInterface $persona);
	
	public function contains(PersonaInterface $persona);
	
}