<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;

interface PersonaRepositoryCacheInterface{

	public function add(PersonaInterface $persona, $rowData);
	
	public function getObject($id);
	
	public function getData($id);
	
	public function has($id);

	public function remove($id);

}