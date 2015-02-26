<?php
namespace phamily\framework\models;

interface AnthroponymInterface{
	
	const FORM_CANONICAL = 'canonical';
	
	public function getType();
	
	public function getValue($form = self::FORM_CANONICAL);
	
	public function isMultiple();
	
}