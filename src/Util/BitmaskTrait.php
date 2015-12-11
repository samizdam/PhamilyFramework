<?php

namespace Phamily\Framework\Util;

/**
 * @author samizdam
 */
trait BitmaskTrait
{
    /**
     * @param int $options
     * @param int $flag
     *
     * @return bool
     */
    protected function isFlagSet($options, $flag)
    {
        return (($options & $flag) == $flag);
    }
}
