<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;

interface PersonaRepositoryInterface{

	public function save(PersonaInterface &$persona);
	public function delete(PersonaInterface &$persona);
}