<?php

namespace phamily\framework\models;

use phamily\framework\collections\ChildrenCollectionInterface;
use phamily\framework\collections\ChildrenCollection;
use phamily\framework\collections\SpouseCollection;
use phamily\framework\collections\SpouseCollectionInterface;
use phamily\framework\models\exceptions\LogicException;
use phamily\framework\models\exceptions\InvalidArgumentException;
use phamily\framework\validators\BaseParentsValidator;
use phamily\framework\validators\ParentsValidatorInterface;
use phamily\framework\validators\ValidatorInterface;
use phamily\framework\value_objects\DateTimeInterface;

class Persona implements PersonaInterface
{
    protected $id;

    protected $gender;

    /**
     * @var NameCollectionInterface
     */
    protected $names;

    /**
     * @var PersonaInterface
     */
    protected $father;

    /**
     * @var PersonaInterface
     */
    protected $mother;

    /**
     * @var ChildrenCollectionInterface|PersonaInterface[]
     */
    protected $children;

    /**
     * @var SpouseCollectionInterface|PersonaInterface[]
     */
    protected $spouses;

    /**
     * @var DateTimeInterface
     */
    protected $dateOfBirth;

    /**
     * @var DateTimeInterface
     */
    protected $dateOfDeath;

    /**
     * @var ParentsValidatorInterface
     */
    protected $parentsValidator;

    public function __construct($gender = self::GENDER_UNDEFINED, array $names = [], Persona $father = null, Persona $mother = null)
    {
        /*
         * TODO may be change constructor for set validatorors, or use that without arguments,
         * becose validators must be configure and set before persona setters will be use.
         */
        $this->parentsValidator = new BaseParentsValidator();

        $this->children = new ChildrenCollection($this);
        $this->spouses = new SpouseCollection($this);

        $this->setGender($gender);

        $this->setFather($father);
        $this->setMother($mother);

        $this->names = new NameCollection();
        foreach ($names as $type => $value) {
            $this->names->add(new Anthroponym($type, $value));
        }
    }

    public function populate($data)
    {
        $data = (object) $data;

        $this->setGender($data->gender);
        $this->id = $data->id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($type, $value)
    {
        throw new \Exception('not implement now');
    }

    /**
     * TODO valide with father / mother / child's DoB's.
     */
    public function setDateOfBirth(DateTimeInterface $date)
    {
        // TODO move to validator
        if (isset($this->dateOfDeath) && $this->dateOfDeath < $date) {
            throw new LogicException("Date of birth can't follow after date of death");
        }
        $this->dateOfBirth = $date;
    }

    public function setDateOfDeath(DateTimeInterface $date)
    {
        // TODO move to validator?
        if ($this->hasDateOfBirth() && $this->dateOfBirth > $date) {
            throw new LogicException("Date of death can't precede before date of birth");
        }
        $this->dateOfDeath = $date;
    }

    public function hasDateOfBirth()
    {
        return isset($this->dateOfBirth);
    }

    public function hasDateOfDeath()
    {
        return isset($this->dateOfDeath);
    }

    public function getDateOfBirth($format = null)
    {
        if (isset($format)) {
            if (isset($this->dateOfBirth)) {
                return $this->dateOfBirth->format($format);
            } else {
                throw new LogicException("date of birth not set for this persona, and can't be formated");
            }
        }

        return $this->dateOfBirth;
    }

    public function getDateOfDeath($format = null)
    {
        if (isset($format)) {
            if (isset($this->dateOfDeath)) {
                return $this->dateOfDeath->format($format);
            } else {
                throw new LogicException("date of death not set for this persona, and can't be formated");
            }
        }

        return $this->dateOfDeath;
    }

    public function setGender($gender)
    {
        if (isset($this->gender) && $this->gender !== $gender) {
            throw new LogicException('Gender already set');
        } elseif ($gender !== self::GENDER_MALE && $gender !== self::GENDER_FEMALE && $gender !== self::GENDER_UNDEFINED) {
            /*
             * TODO may be use UnexpectedValueException for invalid gender?
             */
            throw new InvalidArgumentException("Invalid gender value: {$gender}, possible values: ".self::MALE.', '.self::FEMALE.' or NULL if undefined');
        }
        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getNames()
    {
        return $this->names;
    }

    public function getName($type)
    {
        return $this->names[$type];
    }

    public function getFullName(NamingSchemeInterface $scheme, $formName = NamingSchemeInterface::DEFAULT_FORM)
    {
        return $scheme->build($this->names, $formName);
    }

    public function setFather(PersonaInterface $father = null)
    {
        if ($father instanceof PersonaInterface) {
            if ($this->parentsValidator->isValidFather($this, $father)) {
                $this->father = $father;
                if (!$this->father->getChildren()->contains($this)) {
                    $this->father->addChild($this);
                }
            } else {
                $this->throwValidationErrors($this->parentsValidator);
            }
        }
    }

    public function setMother(PersonaInterface $mother = null)
    {
        if ($mother instanceof PersonaInterface) {
            if ($this->parentsValidator->isValidMother($this, $mother)) {
                $this->mother = $mother;
                if (!$this->mother->getChildren()->contains($this)) {
                    $this->mother->addChild($this);
                }
            } else {
                $this->throwValidationErrors($this->parentsValidator);
            }
        }
    }

    public function hasFather()
    {
        return isset($this->father);
    }

    public function hasMother()
    {
        return isset($this->mother);
    }

    public function getFather()
    {
        return $this->father;
    }

    public function getMother()
    {
        return $this->mother;
    }

    public function addChild(PersonaInterface $child)
    {
        $this->children->add($child);

        // service parents
        switch ($this->gender) {
            case self::GENDER_MALE:
                if (empty($child->getFather())) {
                    $child->setFather($this);
                }
                break;
            case self::GENDER_FEMALE:
                if (empty($child->getMother())) {
                    $child->setMother($this);
                }
                break;
        }
    }

    /**
     * @return ChildrenCollectionInterface|PersonaInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function addSpouse(PersonaInterface $spouse)
    {
        $this->spouses->add($spouse);
        if (!$spouse->getSpouses()->contains($this)) {
            $spouse->addSpouse($this);
        }
    }

    /**
     * (non-PHPdoc).
     * 
     * @see \phamily\framework\models\PersonaInterface::getSpouses()
     *
     * @return SpouseCollectionInterface
     */
    public function getSpouses()
    {
        return $this->spouses;
    }

    protected function throwValidationErrors(ValidatorInterface $validator)
    {
        $message = implode('; ', $validator->getErrors());
        throw new LogicException($message);
    }
}
