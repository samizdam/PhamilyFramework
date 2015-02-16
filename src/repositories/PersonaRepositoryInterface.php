<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;

interface PersonaRepositoryInterface{
	
	public function save(PersonaInterface $persona);
	
	public function getById($id);
	
	public function delete(PersonaInterface $persona);
	
}