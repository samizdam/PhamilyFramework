<?php
namespace phamily\framework\services;

use phamily\framework\models\Persona;
use phamily\framework\models\PersonaInterface;
use phamily\framework\value_objects\DateTimeInterface;
use phamily\framework\repositories\PersonaRepository;
use phamily\framework\repositories\PersonaRepositoryInterface;
use phamily\framework\services\proxies\PersonaRepositoryProxy;
use phamily\framework\traits\BitmaskTrait;

class PersonaService implements PersonaServiceInterface{
	
	use BitmaskTrait;
	
	protected $repository;

	public function __construct(){
		$this->repository = new PersonaRepositoryProxy();
	}
	
	public function useRepository(PersonaRepositoryInterface $repository){
		$this->repository->setRepository($repository);
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
	
	public function getById($id, $fetchWithOptions = self::ALL_KINSHIP){
		return $this->repository->getById($id, $fetchWithOptions);
	}
	
	public function delete(PersonaInterface &$persona){
		$this->repository->delete($persona);
		
		/*
		 * destroy object
		 */
		$persona = null;
	}
	
	public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS){
// 		switch ($degreeOfKinship){
// 			case self::FULL_SIBLINGS: 
// 				if(!$persona->hasFather()){
// // 					$persona = $this->getById($this->)
// 				}
// 				if(!$persona->hasMother()){
// 					$mother = $this->getById($id)
// 				}
// 			break;
// 		}
		
// 		return $siblings;
	}
}