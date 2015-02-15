<?php
namespace phamily\framework\models\collections;

interface ChildrenCollectionInterface extends PersonaCollectionInterface{
	
	public function getParent();
	
}