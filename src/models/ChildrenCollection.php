<?php
namespace phamily\framework\models;

use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\OutOfBoundsException;

class ChildrenCollection implements ChildrenCollectionInterface{
	
	protected $children = [];
	
	protected $parent;
	
	public function __construct(PersonaInterface $parent){
		$this->parent = $parent;
	}
	
	/*
	 * ChildrenCollectionInterface implemantation
	 */
	
	public function add(PersonaInterface $child){
		if($this->contains($child)){
			throw new LogicException("Persona already has this child");
		}
		if($this->parent === $child){
			throw new LogicException("Persona can't be parent for self");
		}
		$this->children[] = $child;
	}
	
	public function contains(PersonaInterface $child){
		return in_array($child, $this->children, true);
	}
	
	/*
	 * SPL Countable implementation
	 */
	
	public function count(){
		return count($this->children);
	}	
	
	/*
	 * SPL SeekableIterator implementation
	 */
	
	protected $position = 0;
	
	public function seek ($position) {
		if($position >= $this->count()){
			throw new OutOfBoundsException("Persona has only {$this->count()} children");
		}
		$this->position = $position;
	}
	
	public function current () {
		return $this->children[$this->position];
	}
	
	public function next () {
		++$this->position; 
	}
	
	public function key () {
		return $this->position;
	}
	
	public function valid () {
		return $this->position < $this->count();
	}
	
	public function rewind () {
		$this->position = 0;
	}
}