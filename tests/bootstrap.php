<?php
require __DIR__.'/../vendor/autoload.php';

use Phinx\Config\Config;
use Phamily\Framework\Util\DatabaseConfigAdapter;

$config = Config::fromYaml(__DIR__ . '/../phinx.yml');
$env = getenv("PHAMILY_TEST_ENV") ?: "testing_sqlite" ;
$envConfig = $config->getEnvironment($env);

echo "tests run with env: '{$env}'";

$dbConfigAdapter = new DatabaseConfigAdapter();
$zendAdaptedConfig = $dbConfigAdapter->adaptPhinxToZend($envConfig);
\Phamily\tests\DbTest::setConfig($zendAdaptedConfig);
