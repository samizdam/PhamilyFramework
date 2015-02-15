<?php
namespace phamily\framework\models;

use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\OutOfRangeException;

class ChildrenCollection implements ChildrenCollectionInterface{
	
	protected $children = [];
	
	protected $parent;
	
	public function __construct(PersonaInterface $parent){
		$this->parent = $parent;
	}
	
	public function add(PersonaInterface $child){
		if($this->contains($child)){
			throw new LogicException("Persona already has this child");
		}		
		$this->children[] = $child;
	}
	
	public function count(){
		return count($this->children);
	}
	
	public function contains(PersonaInterface $child){
		return in_array($child, $this->children, true);
	}
	
	protected $position = 0;
	
	public function seek ($position) {
		if($position >= $this->count()){
			throw new OutOfRangeException("Persona has only {$this->count()} children");
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