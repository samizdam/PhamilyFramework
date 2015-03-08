<?php
require '../vendor/autoload.php';

$config = require 'config.php';

$db = 'mysql';
print 'use db connection: ' . $db.PHP_EOL;
 \phamily\tests\DbTest::setConfig($config[$db]);