<?php
namespace phamily\framework\models;

class Anthroponym implements AnthroponymInterface{
	
	protected $type;
	protected $value;
	
	public function __construct($type, $value){
		$this->type = $type;
		$this->value = $value;
	}
	
	public function populate($data){
		$data = (object) $data;
		$this->type = $data->type;
		$this->value = $data->value;
		return $this;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function __toString(){
		return (string) $this->getValue();
	}
	
}