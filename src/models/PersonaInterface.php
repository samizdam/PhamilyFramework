<?php
namespace phamily\framework\models;

use phamily\framework\GenderAwareInterface;

interface PersonaInterface extends ModelInterface, GenderAwareInterface{
	
	public function getId();
	
	public function setName($type, $value);
	
	public function setDateOfBirth(\DateTimeInterface $date);
	public function setDateOfDeath(\DateTimeInterface $date);
	
	public function getGender();
	
	public function getNameType($type);
	public function getFullName();
	
	public function getFather();
	public function getMother();
	
	public function getChilds();

	public function getSiblings();

}