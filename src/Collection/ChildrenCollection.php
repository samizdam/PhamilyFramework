<?php

namespace Phamily\Framework\Collection;

use Phamily\Framework\Model\PersonaInterface;
use Phamily\Framework\Validator\BaseChildrenValidator;
use Phamily\Framework\Validator\ChildrenValidatorInreface;
use Phamily\Framework\Model\exceptions\LogicException;

class ChildrenCollection extends AbstractPersonaCollection implements ChildrenCollectionInterface
{
    protected $validator;

    /*
     * ChildrenCollectionInterface implementation
     */
    public function getParent()
    {
        return $this->persona;
    }

    public function setValidator(ChildrenValidatorInreface $validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        if (empty($this->validator)) {
            $this->validator = new BaseChildrenValidator();
        }

        return $this->validator;
    }

    protected function validateAddition(PersonaInterface $child)
    {
        if ($this->getValidator()->isValidChild($this, $child)) {
            return true;
        } else {
            throw new LogicException(implode("\n", $this->getValidator()->getErrors()));
        }
    }
}
