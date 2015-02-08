<?php
namespace phamily\framework\models;

interface NameCollectionInterface extends \ArrayAccess{
	
// 	public function setScheme($scheme);
	public function add(AnthroponymInterface $name);
	public function remove(AnthroponymInterface $name);
	
}