<?php

namespace phamily\framework\Collection;

use phamily\framework\Model\PersonaInterface;
use phamily\framework\Validator\BaseChildrenValidator;
use phamily\framework\Validator\ChildrenValidatorInreface;
use phamily\framework\Model\exceptions\LogicException;

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
