<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;

class BasePersonaRepositoryCache implements PersonaRepositoryCacheInterface{

	protected $items = [];
	
	public function add(PersonaInterface $persona, $rowData, $options = 0){
		$this->items[$persona->getId()] = [
			'object' => $persona,
			'data' => $rowData,
			'options' => $options
		];
	}
	
	public function getObject($id){
		return $this->items[$id]['object'];
	}
	
	public function getData($id){
		return $this->items[$id]['data'];
	}
	
	public function getOptions($id){
		return $this->items[$id]['options'];
	}
	
	public function has($id){
		return isset($this->items[$id]);
	}

	public function remove($id){
		unset($this->items[$id]);
	}

}