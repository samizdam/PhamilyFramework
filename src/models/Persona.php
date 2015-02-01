<?php
namespace phamily\framework\models;

class Persona implements PersonaInterface{

	public function getNameType($type){throw new \Exception("not implement now");}
	public function getFullName(){throw new \Exception("not implement now");}
	
	public function getFather(){throw new \Exception("not implement now");}
	public function getMother(){throw new \Exception("not implement now");}
	
	public function getChilds(){throw new \Exception("not implement now");}
	
	public function getSiblings(){throw new \Exception("not implement now");}	
}