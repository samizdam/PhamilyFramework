<?php

namespace Phamily\Framework\Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    protected $errors = [];

    public function getErrors()
    {
        return $this->errors;
    }

    protected function getResult($errors)
    {
        $this->errors = $errors;

        return (count($this->errors) === 0);
    }

    public function reset()
    {
        $this->errors = [];
    }
}
