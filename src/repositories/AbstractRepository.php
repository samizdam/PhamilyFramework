<?php
namespace phamily\framework\repositories;

abstract class AbstractRepository implements RepositoryInterface{
	
	protected $adapter;
	
	public function __construct($adapter){
		$this->adapter = $adapter;
	}
}