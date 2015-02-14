<?php
namespace phamily\framework\models;

interface ChildCollectionInterface extends \Countable, \SeekableIterator{
	public function add(PersonaInterface $child);
}