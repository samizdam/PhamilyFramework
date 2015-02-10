<?php
namespace phamily\framework\models;

use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\InvalidArgumentException;
use phamily\framework\value_objects\DateTimeInterface;

class Persona implements PersonaInterface{

	protected $id;
	
	protected $gender;
	
	/**
	 * 
	 * @var NameCollectionInterface
	 */
	protected $names;
	
	/**
	 * 
	 * @var PersonaInterface
	 */
	protected $father;
	
	/**
	 * 
	 * @var PersonaInterface
	 */
	protected $mother;
	
	/**
	 * 
	 * @var PersonaInterface[]
	 */
	protected $childs;
	
	/**
	 * 
	 * @var DateTimeInterface
	 */
	protected $dateOfBirth;
	
	/**
	 * 
	 * @var DateTimeInterface
	 */
	protected $dateOfDeath;
	
	public function __construct($gender = self::GENDER_UNDEFINED, array $names = [], Persona $father = null, Persona $mother = null){
		$this->setGender($gender);
		$this->setFather($father);
		$this->names = new NameCollection();
		foreach ($names as $type => $value){
			$this->names->add(new Anthroponym($type, $value));
		}
	}
	
	public function populate($data){
		$data = (object) $data;
		
		$this->setGender($data->gender);
		$this->id = $data->id;
		return $this;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setName($type, $value){throw new \Exception("not implement now");}
	
	/**
	 * TODO valide with father / mother / childs DoB's
	 * 
	 */
	public function setDateOfBirth(DateTimeInterface $date){
		if(isset($this->dateOfDeath) && $this->dateOfDeath < $date){
			throw new LogicException("Date of birth can't follow after date of death");
		}
		$this->dateOfBirth = $date;
	}
	
	/**
	 * TODO valide that great of DoB's
	 *
	 */
	public function setDateOfDeath(DateTimeInterface $date){
		if(isset($this->dateOfBirth) && $this->dateOfBirth > $date){
			throw new LogicException("Date of death can't precede before date of birth");
		}
		$this->dateOfDeath = $date;
	}
	
	public function getDateOfBirth($format = null){
		if(isset($format)){
			if(isset($this->dateOfBirth)){
				return $this->dateOfBirth->format($format);
			}else{
				throw new LogicException("date of birth not set for this persona, and can't be formated");
			}
		}
		return $this->dateOfBirth;
	}
	
	public function getDateOfDeath($format = null){
		if(isset($format)){
			if(isset($this->dateOfDeath)){
				return $this->dateOfDeath->format($format);
			}else{
				throw new LogicException("date of death not set for this persona, and can't be formated");
			}
		}
		return $this->dateOfDeath;		
	}
	
	public function setGender($gender){
		if(isset($this->gender) && $this->gender !== $gender){
			throw new LogicException("Gender already set");
		}elseif($gender !== self::GENDER_MALE && $gender !== self::GENDER_FEMALE && $gender !== self::GENDER_UNDEFINED){
			throw new InvalidArgumentException("Invalid gender value: {$gender}, possible values: ".self::MALE.", ".self::FEMALE." or NULL if undefined");
		}
		$this->gender = $gender;
	}
	
	public function getGender(){
		return $this->gender;
	}
	
	public function getNames(){
		return $this->names;
	}
	
	public function getName($type){
		return $this->names[$type];
	}
	
	public function getFullName(NamingSchemeInterface $scheme, $formName = NamingSchemeInterface::DEFAULT_FORM){
		return $scheme->build($this->names, $formName);
	}
	
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