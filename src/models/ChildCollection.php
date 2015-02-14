<?php
namespace phamily\framework\models;

use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\OutOfRangeException;
class ChildCollection implements ChildCollectionInterface{
	
	protected $childs = [];
	
	protected $parent;
	
	public function __construct(PersonaInterface $parent){
		$this->parent = $parent;
	}
	
	public function add(PersonaInterface $child){
		if($this->contains($child)){
			throw new LogicException("Persona already has this child");
		}		
		$this->childs[] = $child;
	}
	
	public function count(){
		return count($this->childs);
	}
	
	public function contains(PersonaInterface $child){
		return in_array($child, $this->childs, true);
	}
	
	protected $position = 0;
	
	public function seek ($position) {
		if($position >= $this->count()){
			throw new OutOfRangeException("Persona has only {$this->count()} childs");
		}
		$this->position = $position;
	}
	
	public function current () {
		return $this->childs[$this->position];
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