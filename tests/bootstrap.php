<?php
require __DIR__.'/../vendor/autoload.php';

$config = require 'config.php';

$db = 'mysql';
print 'use db connection: '.$db.PHP_EOL;
\Phamily\tests\DbTest::setConfig($config[$db]);