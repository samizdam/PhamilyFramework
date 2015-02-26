<?php
namespace phamily\framework\models;

class Anthroponym implements AnthroponymInterface{
	
	protected $id;
	
	protected $type;
	
	protected $value;
	
	protected $isMultiple = false;
	
	/**
	 * 
	 * @param string $type
	 * @param string|array $value
	 */
	public function __construct($type, $value){
		$this->type = $type;
		
		if(is_array($value)){
			$this->isMultiple = true;
		}
		
		$this->value = $value;
	}
	
	public function populate($data){
		$data = (object) $data;
		$this->id = $data->id;
		$this->type = $data->type;
		$this->value = $data->value;
		return $this;
	}
	
	
	public function isMultiple(){
		return $this->isMultiple;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function getValue($form = self::FORM_CANONICAL){
		return $this->value;
	}
	
	public function __toString(){
		return (string) $this->getValue();
	}
	
}