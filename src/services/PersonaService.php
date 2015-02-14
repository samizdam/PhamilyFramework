<?php
namespace phamily\framework\services;

use phamily\framework\models\Persona;
use phamily\framework\models\PersonaInterface;
use phamily\framework\value_objects\DateTimeInterface;
use phamily\framework\repositories\PersonaRepository;
use phamily\framework\repositories\PersonaRepositoryInterface;
use phamily\framework\GenderAwareInterface;

class PersonaService implements PersonaServiceInterface{
	
	protected $repository;

	public function __construct(){
		$this->repository = new RepositoryProxy();
	}
	
	public function useRepository(PersonaRepositoryInterface $repository){
		$this->repository = new RepositoryProxy($repository);
	}
	
	public function isRepositoryUsed(){
		return $this->repository->isActive();
	}
	
	public function create(
			$gender = self::GENDER_UNDEFINED,
			array $names = [], 
			PersonaInterface $father = null,
			PersonaInterface $mother = null,			
			DateTimeInterface $dateOfBirth = null, 
			DateTimeInterface $dateOfDeath = null 
	){
		$persona = new Persona($gender, $names);
		
		$this->repository->save($persona);
		
		return $persona;
	}
	
	public function delete(PersonaInterface &$persona){
		$this->repository->delete($persona);
		
		/*
		 * destroy object
		 */
		$persona = null;
	}
}

class RepositoryProxy implements PersonaRepositoryInterface{
	
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
	
	public function getById($id){
		if($this->isActive()){
			return $this->repository->getById($id);
		}
	}
}