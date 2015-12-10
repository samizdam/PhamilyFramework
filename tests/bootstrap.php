<?php
require __DIR__.'/../vendor/autoload.php';

use Phinx\Config\Config;
use Phamily\Framework\Util\DatabaseConfigAdapter;

$config = Config::fromYaml(__DIR__ . '/../phinx.yml');
$envName = getenv("PHAMILY_TEST_ENV");
$envConfig = $config->getEnvironment($envName);

echo "tests run with env: '{$envName}'";

$dbConfigAdapter = new DatabaseConfigAdapter();
$zendAdaptedConfig = $dbConfigAdapter->adaptPhinxToZend($envConfig);
\Phamily\tests\DbTest::setConfig($zendAdaptedConfig);
