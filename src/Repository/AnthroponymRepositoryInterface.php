<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\AnthroponymInterface;

/**
 *
 * @author samizdam
 *
 */
interface AnthroponymRepositoryInterface
{
    /**
     *
     *
     * @param AnthroponymInterface $anthroponym
     * @return AnthroponymInterface
     */
    public function save(AnthroponymInterface $anthroponym);

    /**
     *
     *
     * @param AnthroponymInterface $anthroponym
     * @return void
     */
    public function delete(AnthroponymInterface $anthroponym);

    /**
     *
     *
     * @param string $type
     * @return AnthroponymInterface
     */
    public function getByType($type);
    // public function getByValue();
}
