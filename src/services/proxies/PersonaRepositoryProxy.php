<?php
namespace phamily\framework\services\proxies;

use phamily\framework\repositories\PersonaRepositoryInterface;
use phamily\framework\models\PersonaInterface;

class PersonaRepositoryProxy implements PersonaRepositoryInterface{

	protected $repository;
	protected $active = false;

	public function __construct(PersonaRepositoryInterface $repository = null){
		if(isset($repository)){
			$this->setRepository($repository);
		}
	}

	public function setRepository(PersonaRepositoryInterface $repository){
		$this->repository = $repository;
		$this->active = true;
	}

	public function isActive(){
		return $this->active;
	}

	public function save(PersonaInterface $persona){
		if($this->isActive()){
			return $this->repository->save($persona);
		}
	}

	public function delete(PersonaInterface $persona){
		if($this->isActive()){
			return $this->repository->delete($persona);
		}
	}

	public function getById($id, $fetchWithOptions = self::WITHOUT_KINSHIP){
		if($this->isActive()){
			return $this->repository->getById($id, $fetchWithOptions);
		}
	}
}