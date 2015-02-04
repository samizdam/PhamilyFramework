<?php
namespace phamily\framework\services;

use phamily\framework\models\PersonaInterface;
use phamily\framework\GenderAwareInterface;

interface PersonaServiceInterface extends GenderAwareInterface{
	public function create(
			$gender,
			array $names = [], 
			\DateTimeInterface $dateOfBirth = null, 
			\DateTimeInterface $dateOfDeath = null, 
			PersonaInterface $father = null, 
			PersonaInterface $mother = null
	);
	
// 	public function findByNames(array $names = []){
		
// 	}
}
