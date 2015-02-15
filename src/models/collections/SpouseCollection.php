<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;
use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\validators\SpouseValidatorInterface;
use phamily\framework\models\validators\BaseSpouseValidator;

class SpouseCollection extends AbstractPersonaCollection implements SpouseCollectionInterface{
	
	protected $validator;
	
	public function getOwner(){
		return $this->persona;
	}
	
	public function setValidator(SpouseValidatorInterface $validator){
		$this->validator = $validator;
	}
	
	public function getValidator(){
		if(empty($this->validator)){
			$this->validator = new BaseSpouseValidator();
		}
		return $this->validator;
	}
	
	protected function validateAddition(PersonaInterface $spouse){
		if($this->getValidator()->isValidSpouse($this->getOwner(), $spouse)){
			return true;
		}else{
			throw new LogicException(join("\n", $this->getValidator()->getErrors()));
		}
		
	}
}