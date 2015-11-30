<?php

namespace phamily\framework\Model;

use phamily\framework\GenderAwareInterface;
use phamily\framework\ValueObject\DateTimeInterface;

interface PersonaInterface extends ModelInterface, GenderAwareInterface
{
    public function getId();

    public function setName($type, $value);

    public function setDateOfBirth(DateTimeInterface $date);

    public function setDateOfDeath(DateTimeInterface $date);

    public function hasDateOfBirth();

    public function hasDateOfDeath();

    public function getDateOfBirth($format = null);

    public function getDateOfDeath($format = null);

    public function setGender($gender);

    public function getGender();

    public function getNames();

    public function getName($type);

    public function getFullName(NamingSchemeInterface $scheme, $formName);

    public function setFather(PersonaInterface $father);

    public function setMother(PersonaInterface $mother);

    public function hasFather();

    public function hasMother();

    public function getFather();

    public function getMother();

    public function addChild(PersonaInterface $child);

    public function getChildren();

    public function addSpouse(PersonaInterface $spouse);

    public function getSpouses();
}
