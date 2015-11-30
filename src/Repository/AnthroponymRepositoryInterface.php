<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\AnthroponymInterface;

interface AnthroponymRepositoryInterface
{
    public function save(AnthroponymInterface $anthroponym);

    public function delete(AnthroponymInterface $anthroponym);

    public function getByType($type);
    // public function getByValue();
}
