<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;

class SpouseCollection implements SpouseCollectionInterface{
	
	protected $persona;
	
	public function __construct(PersonaInterface $persona){
		$this->persona = $persona;
	}
	
	/*
	 * ChildrenCollectionInterface implemantation
	*/
	
	protected $spouses = [];
	
	public function add(PersonaInterface $spouse){
		$this->spouses[] = $spouse;
		
	}
	
	public function contains(PersonaInterface $spouse){
		return in_array($spouse, $this->spouses, true);
	}
	
	/*
	 * SPL Countable implementation
	*/
	
	public function count(){
		return count($this->spouses);
	}
	
	/*
	 * SPL SeekableIterator implementation
	*/
	
	protected $position = 0;
	
	public function seek ($position) {
		if($position >= $this->count()){
			throw new OutOfBoundsException("Persona has only {$this->count()} spouses");
		}
		$this->position = $position;
	}
	
	public function current () {
		return $this->spouses[$this->position];
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