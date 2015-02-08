<?php
namespace phamily\framework\models;

interface NamingSchemeInterface{
	const DEFAULT_FORM = 'default';

	public function setType($type);
	public function setConfig(array $config);
	
	public function getType();
	public function getConfig();
	
	public function hasForm($formName);
	
	public function build(NameCollectionInterface $names, $formName);
}