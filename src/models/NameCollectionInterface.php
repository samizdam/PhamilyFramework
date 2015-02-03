<?php
namespace phamily\framework\models;

interface NameCollectionInterface extends \ArrayAccess{
	
	public function add(NameInterface $name);
	public function remove(NameInterface $name);
	
}