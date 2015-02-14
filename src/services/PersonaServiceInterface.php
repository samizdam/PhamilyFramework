<?php
namespace phamily\framework\services;

use phamily\framework\models\PersonaInterface;
use phamily\framework\GenderAwareInterface;
use phamily\framework\value_objects\DateTimeInterface;

interface PersonaServiceInterface extends GenderAwareInterface{
	public function create(
			$gender,
			array $names = [], 
			PersonaInterface $father = null, 
			PersonaInterface $mother = null,
			DateTimeInterface $dateOfBirth = null,
			DateTimeInterface $dateOfDeath = null			
	);
	
	public function delete(PersonaInterface &$persona);
	
// 	public function findByNames(array $names = []){
		
// 	}
}
