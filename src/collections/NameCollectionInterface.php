<?php
namespace phamily\framework\collections;

use phamily\framework\models\AnthroponymInterface;

interface NameCollectionInterface extends \ArrayAccess{

	public function add(AnthroponymInterface $name);
	public function remove(AnthroponymInterface $name);
	
}