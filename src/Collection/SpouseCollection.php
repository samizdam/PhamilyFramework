<?php

namespace Phamily\Framework\Collection;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\Model\exceptions\LogicException;
use Phamily\Framework\Validator\SpouseValidatorInterface;
use Phamily\Framework\Validator\BaseSpouseValidator;

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
