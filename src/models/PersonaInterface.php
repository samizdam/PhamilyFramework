<?php
namespace phamily\framework\models;

use phamily\framework\GenderAwareInterface;
use phamily\framework\value_objects\DateTimeInterface;

interface PersonaInterface extends ModelInterface, GenderAwareInterface{
	
	public function getId();
	
	public function setName($type, $value);
	
	public function setDateOfBirth(DateTimeInterface $date);
	public function setDateOfDeath(DateTimeInterface $date);
	
	public function getDateOfBirth($format = null);
	public function getDateOfDeath($format = null);
	
	public function getGender();
	
	public function getNames();
	
	public function getName($type);
	public function getFullName(NamingSchemeInterface $scheme, $formName);
	
	
	
	public function getFather();
	public function getMother();
	
	public function getChilds();

	public function getSiblings();
}