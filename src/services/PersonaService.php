<?php
namespace phamily\framework\services;

use phamily\framework\models\Persona;
use phamily\framework\models\PersonaInterface;
use phamily\framework\value_objects\DateTimeInterface;

class PersonaService implements PersonaServiceInterface{
	public function create(
			$gender = self::UNDEFINED,
			array $names = [], 
			PersonaInterface $father = null,
			PersonaInterface $mother = null,			
			DateTimeInterface $dateOfBirth = null, 
			DateTimeInterface $dateOfDeath = null 
	){
		return new Persona($gender, $names);
	}
}

