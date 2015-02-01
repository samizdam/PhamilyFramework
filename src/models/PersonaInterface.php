<?php
namespace phamily\framework\models;

interface PersonaInterface{
	
	public function getNameType($type);
	public function getFullName();
	
	public function getFather();
	public function getMother();
	
	public function getChilds();

	public function getSiblings();

}