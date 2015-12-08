<?php
require __DIR__.'/../vendor/autoload.php';

use Phinx\Config\Config;
use Phamily\Framework\Util\DatabaseConfigAdapter;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;


$config = Config::fromYaml(__DIR__ . '/../phinx.yml');
$envName = getenv("PHAMILY_TEST_ENV") ?: "testing_sqlite" ;
$envConfig = $config->getEnvironment($envName);

echo "tests run with env: '{$envName}'";

$dbConfigAdapter = new DatabaseConfigAdapter();
$zendAdaptedConfig = $dbConfigAdapter->adaptPhinxToZend($envConfig);
\Phamily\tests\DbTest::setConfig($zendAdaptedConfig);

// migrate test-db
$manager = new Manager($config, new DummyOutput());
$env = $manager->getEnvironment($envName);

$manager->rollback($envName);
$manager->migrate($envName);
$manager->rollback($envName);
