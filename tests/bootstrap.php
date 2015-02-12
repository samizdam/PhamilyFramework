<?php
require '../vendor/autoload.php';

// spl_autoload_register(function($className){
// 	$filename = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
// 	if(file_exists($filename)) require_once $filename;
// });

$config = require 'config.php';

 \phamily\tests\DbTest::setConfig($config['db']);