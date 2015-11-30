<?php

namespace phamily\framework\Collection;

use phamily\framework\Model\PersonaInterface;
use phamily\framework\Model\exceptions\LogicException;
use phamily\framework\Validator\SpouseValidatorInterface;
use phamily\framework\Validator\BaseSpouseValidator;

class SpouseCollection extends AbstractPersonaCollection implements SpouseCollectionInterface
{
    protected $validator;

    public function getOwner()
    {
        return $this->persona;
    }

    public function setValidator(SpouseValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        if (empty($this->validator)) {
            $this->validator = new BaseSpouseValidator();
        }

        return $this->validator;
    }

    protected function validateAddition(PersonaInterface $spouse)
    {
        if ($this->getValidator()->isValidSpouse($this->getOwner(), $spouse)) {
            return true;
        } else {
            throw new LogicException(implode("\n", $this->getValidator()->getErrors()));
        }
    }
}
