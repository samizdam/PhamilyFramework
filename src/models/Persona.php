<?php
namespace phamily\framework\models;

use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\InvalidArgumentException;
class Persona implements PersonaInterface{

	protected $id;
	
	protected $gender;
	protected $names;
	protected $father;
	protected $mother;
	protected $childs;
	
	
	
	public function __construct($gender = self::GENDER_UNDEFINED, array $names = [], Persona $father = null, Persona $mother = null){
		$this->setGender($gender);
		$this->setFather($father);
// 		$this->mother = $mother;
	}
	
	public static function populate($data){
		$persona = new self($data->gender);
		$persona->id = $data->id;
		return $persona;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setName($type, $value){throw new \Exception("not implement now");}
	
	public function setDateOfBirth(\DateTimeInterface $date){throw new \Exception("not implement now");}
	public function setDateOfDeath(\DateTimeInterface $date){throw new \Exception("not implement now");}
	
	public function setGender($gender){
		if($this->gender){
			throw new LogicException("Gender already set");
		}elseif($gender !== self::GENDER_MALE && $gender !== self::GENDER_FEMALE && $gender !== self::GENDER_UNDEFINED){
			throw new InvalidArgumentException("Invalid gender value: {$gender}, possible values: ".self::MALE.", ".self::FEMALE." or NULL if undefined");
		}
		$this->gender = $gender;
	}
	
	public function getGender(){
		return $this->gender;
	}
	
	public function getNameType($type){throw new \Exception("not implement now");}
	public function getFullName(){throw new \Exception("not implement now");}
	
	public function setFather(Persona $father = null){
		if($father instanceof Persona && $father->getGender() !== self::GENDER_MALE){
			throw new LogicException("Father must be a male");
		}
		$this->father = $father;
	}
	
	public function getFather(){
		return $this->father;
	}
	public function getMother(){throw new \Exception("not implement now");}
	
	public function getChilds(){throw new \Exception("not implement now");}
	
	public function getSiblings(){throw new \Exception("not implement now");}	
}