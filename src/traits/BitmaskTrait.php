<?php
namespace phamily\framework\traits;

trait BitmaskTrait
{

    protected function isFlagSet($options, $flag)
    {
        return (($options & $flag) == $flag);
    }
}