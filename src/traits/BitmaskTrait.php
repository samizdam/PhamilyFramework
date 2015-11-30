<?php

namespace Phamily\Framework\traits;

trait BitmaskTrait
{
    protected function isFlagSet($options, $flag)
    {
        return (($options & $flag) == $flag);
    }
}
