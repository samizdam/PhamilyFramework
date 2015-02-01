<?php
namespace phamily\framework\services;

use phamily\framework\models\Persona;
use phamily\framework\models\PersonaInterface;

class PersonaService implements PersonaServiceInterface{
	public function create(
			$gender = self::UNDEFINED,
			array $names = [], 
			\DateTimeInterface $dateOfBirth = null, 
			\DateTimeInterface $dateOfDeath = null, 
			PersonaInterface $father = null, 
			PersonaInterface $mother = null
	){
		return new Persona($gender);
	}
}

