<?php
namespace phamily\framework\models;

class Anthroponym implements AnthroponymInterface
{

    protected $id;

    protected $type;

    protected $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function populate($data)
    {
        $data = (object) $data;
        $this->id = $data->id;
        $this->type = $data->type;
        $this->value = $data->value;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->getValue();
    }
}