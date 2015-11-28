<?php

namespace phamily\framework\repositories;

use phamily\framework\models\AnthroponymInterface;

interface AnthroponymRepositoryInterface
{
    public function save(AnthroponymInterface $anthroponym);

    public function delete(AnthroponymInterface $anthroponym);

    public function getByType($type);
    // public function getByValue();
}
