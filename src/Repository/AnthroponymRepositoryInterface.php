<?php

namespace phamily\framework\Repository;

use phamily\framework\Model\AnthroponymInterface;

interface AnthroponymRepositoryInterface
{
    public function save(AnthroponymInterface $anthroponym);

    public function delete(AnthroponymInterface $anthroponym);

    public function getByType($type);
    // public function getByValue();
}