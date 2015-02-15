<?php
namespace phamily\framework\models;

interface ChildrenCollectionInterface extends \Countable, \SeekableIterator{
	public function add(PersonaInterface $child);
}