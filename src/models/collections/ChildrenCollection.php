<?php
namespace phamily\framework\models\collections;

use phamily\framework\models\PersonaInterface;
use phamily\framework\validators\BaseChildrenValidator;
use phamily\framework\validators\ChildrenValidatorInreface;
use phamily\framework\models\exceptions\LogicException;

class ChildrenCollection extends AbstractPersonaCollection implements ChildrenCollectionInterface{
	
	protected $validator;
	
	/*
	 * ChildrenCollectionInterface implementation
	 */
	
	public function getParent(){
		return $this->persona;
	}

	public function setValidator(ChildrenValidatorInreface $validator){
		$this->validator = $validator;
	}
	
	public function getValidator(){
		if(empty($this->validator)){
			$this->validator = new BaseChildrenValidator();
		}
		return $this->validator;
	}
	
	protected function validateAddition(PersonaInterface $child){
		if($this->getValidator()->isValidChild($this, $child)){
			return true;
		}else{
			throw new LogicException(join("\n", $this->getValidator()->getErrors()));
		}
	}
	
}