<?php
namespace phamily\framework\repositories;

use phamily\framework\models\PersonaInterface;
use Zend\Db\RowGateway\RowGateway;

class PersonaRepository extends AbstractRepository implements PersonaRepositoryInterface{
	
	public function save(PersonaInterface &$persona){
		$row = new RowGateway('id', 'persona', $this->adapter);
		$data = [
			'gender' => $persona->getGender(),
			'fatherId' => empty($persona->getFather()) ? null : $persona->getFather()->getId(),
		];
		$row->populate($data);
		$row->save();
		$persona = $persona->populate($row);
		return $persona;
	}
	
	public function delete(PersonaInterface &$persona){
		
	}
}