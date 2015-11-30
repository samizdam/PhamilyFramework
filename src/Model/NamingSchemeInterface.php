<?php

namespace phamily\framework\Model;

interface NamingSchemeInterface
{
    const DEFAULT_FORM = 'default';

    public function setType($type);

    public function setConfig(array $config);

    public function getType();

    public function getConfig();

    public function hasForm($formName);

    public function build(NameCollectionInterface $names, $formName);
}
